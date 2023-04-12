<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProduitsType;
use App\Entity\Produits;
use Doctrine\ORM\EntityManagerInterface;

class BaseController extends AbstractController
{
    #[Route('/index', name: 'index')]
    public function index(EntityManagerInterface $entityManagerInterface): Response
    {
        $repoProduits = $entityManagerInterface->getRepository(Produits::class);
        $produits = $repoProduits->findAll();
        return $this->render('base/index.html.twig', [
        'produits'=>$produits
        ]);
    }
    #[Route('/produits', name: 'produits')]
    public function produits(): Response
    {
        $form = $this->createForm(ProduitsType::class);
        return $this->render('produits/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/mentions', name: 'mentions')]
    public function mentions(): Response
    {
        return $this->render('base/mentions.html.twig', [
        
        ]);
    }
    #[Route('/conditions', name: 'conditions')]
    public function consitions(): Response
    {
        return $this->render('base/conditions.html.twig', [
        
        ]);
    }
}
