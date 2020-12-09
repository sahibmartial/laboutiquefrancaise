<?php

namespace App\Controller;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use App\Classe\Cart;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class CartController extends AbstractController
{
  private $entityManager;

	public function __construct(EntityManagerInterface $entityManager) {
		$this->entityManager = $entityManager;
	}
    /**
    *importe dependance de la calsse Cart
     * @Route("/mon-panier", name="cart")
     */
    public function index(Cart $cart): Response
    {
       //dd($cart->get());//appelle moi la fovtion de ma classe Cart
      //  dd($cartComplete);
      return $this->render('cart/index.html.twig',[
        'cart'=>$cart->getCart()
      ]);

    }

    /**
     * @Route("/cart/add/{id}", name="add_to_cart")
     */
    public function add(Cart $cart,$id): Response
    {
        $cart->add($id);//appel fonctio add de ma Classe Cart
        //return $this->render('cart/index.html.twig');
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/remove", name="remove_my_cart")
     */
    public function remove(Cart $cart): Response
    {
        $cart->remove();//appel fonctio remove de ma Classe Cart
        //return $this->render('cart/index.html.twig');
        return $this->redirectToRoute('products');
    }


    /**
     * @Route("/cart/delete/{id}", name="delete_to_cart")
     */
    public function delete(Cart $cart,$id): Response
    {
        $cart->delete($id);//appel fonction delete de ma Classe Cart
        //return $this->render('cart/index.html.twig');
        return $this->redirectToRoute('cart');
    }

    /**
     * @Route("/cart/decrease/{id}", name="decrease_to_cart")
     */
    public function decrease(Cart $cart,$id): Response
    {
        $cart->decrease($id);//appel fonction decrease de ma Classe Cart
        //return $this->render('cart/index.html.twig');
        return $this->redirectToRoute('cart');
    }



}
