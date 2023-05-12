<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AjouterController extends AbstractController
{
    #[Route('/ajouter', name: 'app_ajouter')]
    public function index(): Response
    {
        return $this->render('ajouter/index.html.twig', [
            'controller_name' => 'AjouterController',
        ]);
    }
    #[Route('/liste-ajout', name: 'liste-ajout')]
    public function listeAjout(EntityManagerInterface $entityManagerInterface): Response
    {
        $repoAjouter = $entityManagerInterface->getRepository(Ajouter::class);
        $ajouter = $repoAjouter->findAll();
        return $this->render('ajouter/liste-ajout.html.twig', [
           'ajouter' => $ajouter
        ]);
    }
}
