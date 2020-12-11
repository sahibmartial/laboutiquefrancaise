<?php

namespace App\Controller;

use App\Entity\Address;
use App\Form\AddressType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;

class AccountAddressController extends AbstractController
{

	private $entityManager;
	public function __construct(EntityManagerInterface $entityManager)
	{
	  $this->entityManager=$entityManager;
	}
    /**
     * @Route("/compte/addresses", name="account_address")
     */
    public function index(): Response
    {
    	//dd($this->getUser());
        return $this->render('account/address.html.twig');
    }

    /**
     * @Route("/compte/ajouter-une-addresse", name="account_address_add")
     */
    public function add(Request $request): Response
    {
    	//dd($this->getUser());
    	$address= new Address();
    	$form=$this->createForm(AddressType::class, $address);

    	$form->handleRequest($request);//recup data in form and check it
       
        if ($form->isSubmitted() && $form->isValid()) {

        	 $address->setUser($this->getUser());
        	// $this->addFlash('success', 'Article Created! Knowledge is power!');
	
        	$this->entityManager->persist($address);
        	$this->entityManager->flush();

           return $this->redirectToRoute('account_address');

        }

        return $this->render('account/address_form.html.twig',[
        	'form'=>$form->createview()]);
    }

    /**
     * @Route("/compte/modifier-une-addresse/{id}", name="account_address_edit")
     */
    public function edit(Request $request,$id): Response
    {
    	//dd($this->getUser());
    	$address=$this->entityManager->getRepository(Address::class )->findOneById($id);
    	//verifie address existe et c'est pour le user connecter 
    	if (!$address || $address->getUser() != $this->getUser() ) {
    		return $this->redirectToRoute('account_address');
    	}

    	$form=$this->createForm(AddressType::class, $address);

    	$form->handleRequest($request);//recup data in form and check it
       
        if ($form->isSubmitted() && $form->isValid()) {

        	// $this->addFlash('success', 'Article Created! Knowledge is power!');   	
        	$this->entityManager->flush();

           return $this->redirectToRoute('account_address');

        }

        return $this->render('account/address_form.html.twig',[
        	'form'=>$form->createview()]);
    }

    /**
     * @Route("/compte/supprimer-une-addresse/{id}", name="account_address_delete")
     */
    public function delete($id): Response
    {
    	//dd($this->getUser());
    	$address=$this->entityManager->getRepository(Address::class )->findOneById($id);
    	//verifie address existe et c'est pour le user connecter 
    	if ($address && $address->getUser() == $this->getUser() ) {

    		$this->entityManager->remove($address);
    		$this->entityManager->flush();

    		
    	} 
    	return $this->redirectToRoute('account_address');
        
    }

}
