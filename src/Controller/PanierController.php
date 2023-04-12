<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Entity\User;
use App\Entity\Panier;
use App\Form\ProduitsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    #[Route('/private-panier', name: 'panier')]
    public function Panier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id=$request->get('id');
        $action = $request->get('action');
        $produits = $entityManagerInterface->getRepository(Produits::class)->find($id);

        if($action=='supprimer'){$this->getUser()->removeAjouter($produits);
        }
        if($action=='ajouter'){$this->getUser()->addAjouter($produits);
        }      
                $entityManagerInterface->persist($this->getUser());
                $entityManagerInterface->flush();
                return $this->redirectToRoute('index');
       
    }
}
