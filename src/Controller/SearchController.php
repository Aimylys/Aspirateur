<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Form\ProduitsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class SearchController extends AbstractController
{
    #[Route('/search', name: 'search')]
    public function rechercheProduits(EntityManagerInterface $entityManagerInterface,Request $request): Response
{
    $research = $request->query->get('q');
    if ($research == "") {
        return $this->redirectToRoute('index.html.twig');
    }else{
        
        $repoProduits = $entityManagerInterface->getRepository(Produits::class);
        $query = $entityManagerInterface->createQuery('SELECT p FROM App\Entity\Produits p WHERE p.nom LIKE :research')->setParameter('research', '%'.$research.'%');
        $produits = $query->getResult();
        
        return $this->render('produits/recherche.html.twig', [
            'produits' => $produits,
            'query' => $research,
        ]);
    }
    
}

}
