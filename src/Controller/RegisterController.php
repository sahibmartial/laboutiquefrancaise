<?php

namespace App\Controller;
use App\Form\RegisterType;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterController extends AbstractController
{
	private $entityManager;
	public function __construct(EntityManagerInterface $entityManager)
	{
	  $this->entityManager=$entityManager;
	}
	
    /**
     * @Route("/inscription", name="register")
     */
    public function index(Request $request,UserPasswordEncoderInterface $encoder): Response
    {
    	/* [
            'controller_name' => 'RegisterController',
        ]*/

        $user= new User();//permetra de faire insertion ds la table 
        $form=$this->createForm(RegisterType::class,$user);

          $form->handleRequest($request);//recup data in form and check it
        
        if ($form->isSubmitted() && $form->isValid()) {
        	$user=$form->getData();
        	$passwd=$encoder->encodePassword($user,$user->getPassword());
        	//dump($passwd);
        	$user->setPassword($passwd);
        	//dd($user);
        	$this->entityManager->persist($user);
        	$this->entityManager->flush();

        }

        return $this->render('register/index.html.twig',[
            'form' =>$form->createView()
        ]);
    }
}
