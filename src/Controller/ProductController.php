<?php

namespace App\Controller;

use App\Entity\Product;
use App\Classe\Search;
use App\Form\SearchType;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ProductController extends AbstractController {

	private $entityManager;

	public function __construct(EntityManagerInterface $entityManager) {
		$this->entityManager = $entityManager;
	}
	/**
	 * @Route("/nos-produits", name="products")
	 */
	public function index(Request $request):Response {
		$search = new Search();
		//dd($search);
		$form=$this->createForm(SearchType::class , $search);
		//cree mon formulaire a partir de ma classe SearchType et ac les pptes de la class Search
		//dd($products);
		$form->handleRequest($request);//recup data in form and check it
		  if ($form->isSubmitted() && $form->isValid())
			{
				$products = $this->entityManager->getRepository(Product::class )->findWithSearch($search);
			//	dd($product);
		}else {
				$products = $this->entityManager->getRepository(Product::class )->findAll();
		}

		return $this->render('product/index.html.twig',
			['products' => $products,
				'form'     => $form->createview()

			]);
	}

	/**
	 * @Route("/produit/{slug}", name="product")
	 */
	public function show($slug):Response {
		//dd($slug);
		$product = $this->entityManager->getRepository(Product::class )->findOneBySlug($slug);
		//dd($products);
		if (!$product) {

			return $this->redirectToRoute('products');
		}

		return $this->render('product/show.html.twig',
			['product' => $product
			]);
	}
}
