<?php

namespace App\Controller;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\ChangePasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountPasswordController extends AbstractController
{
	private $entityManager;
	public function __construct(EntityManagerInterface $entityManager)
	{
	  $this->entityManager=$entityManager;
	}
    /**
     * @Route("/compte/modifier_password", name="account_password")
     */
    public function index(Request $request, UserPasswordEncoderInterface $encoder): Response
    {
    	$notification=null;

    	$user=$this->getUser();
    	$form=$this->createForm(ChangePasswordType::class,$user);

    	$form->handleRequest($request);//ecoute un form

    	if ($form->isSubmitted() && $form->isSubmitted()) {
    		$old_passwd=$form->get('old_password')->getData();

    		//check old_pwd in base and  what you tape
    		if ($encoder->isPasswordValid($user,$old_passwd)) {
    			//die('true');
    			//get new password
    			$new_pwd=$form->get('new_password')->getData();
    			$passwd=$encoder->encodePassword($user,$new_pwd);

    			$user->setPassword($passwd);

    			//$this->entityManager->persist($user);
        	   $this->entityManager->flush();
        	   $notification="Votre mot de passe a bien été mis a jour !!";

    		}else{
                $notification="Votre mot de passe actuel n'est pas bon !!"; 

    		}

    	}

        return $this->render('account/password.html.twig',[
        	'form'=>$form->createView(),
        	'notification'=>$notification
        ]);
    }
}
