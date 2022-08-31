<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;


class Cart 

{
	//private $session;
	private $requestStack;

	//public function __construct(SessionInterface $session)
	public function __construct(RequestStack $requestStack)
	{
	//$this->session = $session;
	$this->requestStack = $requestStack;
	}


	public function add($id)
	{
		// On récupère les informations du panier à l'aide de la session
		$cart = $this->requestStack->getSession()->get('cart', []);

		// Si dans le panier il y a un produit déjà inséré
		if (!empty($cart[$id])) {
			// On incrémente
        	$cart[$id]++; 
		} else {
			$cart[$id] = 1;
		}
		// Il s'agit du set de la biblihothèque SessionInterface (Sets an attribute.)
		// On stock les informations du panier dans une session (cart)
		$this->requestStack->getSession()->set('cart',$cart); 
	}

    // AJOUTER au panier
	public function get()
	{
		// Il s'agit du get de la biblihothèque SessionInterface (Returns an attribute.)
		return $this->requestStack->getSession()->get('cart');
	}

    // SUPPRIME le panier
	public function remove()
	{
		// Il s'agit du remove de la biblihothèque SessionInterface (Removes an attribute.)
		return $this->requestStack->getSession()->remove('cart');
	}

}
