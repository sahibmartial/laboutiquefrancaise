<?php
namespace App\Classe;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
/**
 *
 */
class Cart
{
  private $session;
  private $entityManager;
 public  function __construct(EntityManagerInterface $entityManager,SessionInterface $session)
  {
   $this->session=$session;
   $this->entityManager = $entityManager;
  }

  public function add($id)
 {

   $cart=$this->session->get('cart',[]);

   if (!empty($cart[$id])) {
     $cart[$id]++;
   }else {
     $cart[$id]=1;
   }
   //dd($cart);
  return  $this->session->set('cart', $cart);//creation du panier
 }

 public function get()
{
  return $this->session->get('cart');
}
//mieux retirer le produit que vider le panier don i a recuperer
public function remove()
{
 return $this->session->remove('cart');//vide le panier
}
//retire un article du panier
public function delete($id)
{
  //faut recupere la qty de l id
  $cart=$this->session->get('cart',[]);
  unset($cart[$id]);
  return  $this->session->set('cart', $cart);
}
/**
*
*/
public function decrease($id)
{
  $cart=$this->session->get('cart',[]);
  if ($cart[$id]>1) {
    $cart[$id]--;
  }else {

      unset($cart[$id]);
  }
  return  $this->session->set('cart', $cart);
}

public function getCart()
{
  $cartComplete=[];
  if ($this->get()) {
    foreach ($this->get() as $id => $quantity) {
      $product_object=$this->entityManager->getRepository(Product::class )->findOneById($id);
      if (!$product_object) {
        $this->delete($id);
        continue;
      }
      $cartComplete[]=[
        'product'=>$product_object,
      'quantity'=>$quantity];
    }
  }
  return   $cartComplete;
}




}
