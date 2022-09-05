<?php

namespace App\Classe;

use Symfony\Component\HttpFoundation\RequestStack;

class Cart

{
	// J'initialise une session
    private $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function add($id) //ajoute les products dans le panier
    {
        $session = $this->requestStack->getSession();

        $cart = $session->get('cart'); //on récupère les informations du panier à l'aide de la session

        if (!empty($cart[$id])) {

            $cart[$id]++; //on incrémente
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
    }


    public function get()  //affiche le panier
    {
        $session = $this->requestStack->getSession();
        return $session->get('cart');
    }


    public function remove()  //vide le panier
    {
        $session = $this->requestStack->getSession();
        return $session->remove('cart');
    }

    public function delete($id)  //supprime un produit du panier 
    {
        $session = $this->requestStack->getSession();  //je lance une session
        $cart = $session->get('cart', []);              //je recupére les infos de ma session cart
        unset($cart[$id]);                           //je supprime de mon tableau  l'element corrspondant

        return $session->set('cart', $cart);        //je redéfins la nouvelle valeur dans la session cart
    }

	// REDUIRE
	public function decrease($id)
	{
		// On récupère les informations du panier à l'aide de la session
		$cart = $this->requestStack->getSession()->get('cart', []);

		// Vrérifier si la quantité de notre produit = 1
		if ($cart[$id] > 1) {
			// Retirer une quantité (-1)
			$cart[$id]--; 
			
		} else {
			// Supprimer mon produit
			unset($cart[$id]);
		}
		
		// Je redéfini la même route que mon panier
		$this->requestStack->getSession()->set('cart',$cart); 
	}
}