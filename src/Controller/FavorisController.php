<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Form\ProduitsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class FavorisController extends AbstractController
{
    #[Route('/private-favoris', name: 'favoris')]
    public function Favoris(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id=$request->get('id');
        if(isset($id)){
        $action = $request->get('action');
        $produits = $entityManagerInterface->getRepository(Produits::class)->find($id);

        if($action=='supprimer'){$this->getUser()->removeFavori($produits);
        }
        if($action=='ajouter'){$this->getUser()->addFavori($produits);
        }      
                $entityManagerInterface->persist($this->getUser());
                $entityManagerInterface->flush();
        }
        return $this->redirectToRoute('index');
    }
}
