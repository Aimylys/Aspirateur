<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Form\ProduitsType;
use App\Form\ModifProduitsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class ProduitsController extends AbstractController
{
    #[Route('/produits', name: 'produits')]
    public function produits(): Response
    {
        $form = $this->createForm(ProduitsType::class);
        return $this->render('produits/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/liste-produits', name: 'liste-produits')]
    public function listeProduits(EntityManagerInterface $entityManagerInterface): Response
    {
        $repoProduits = $entityManagerInterface->getRepository(Produits::class);
        $produits = $repoProduits->findAll();
        return $this->render('produits/liste-produits.html.twig', [
           'produits' => $produits
        ]);
    } 
    //route pour afficher les contacts un par un
    #[Route('/modif-produits/{id}', name: 'modif-produits')]
    public function ModifProduitsController(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id=$request->get('id');
        $repoProduits = $entityManagerInterface->getRepository(Produits::class);
        $produits = $repoProduits->find($id);
        $form=$this->createForm(ModifProduitsType::class,$produits);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
              
                $entityManagerInterface->persist($produits);
                $entityManagerInterface->flush();

                $this->addFlash('notice','Modification réussi');
                return $this->redirectToRoute('liste-produits');
              
            }
        }

        return $this->render('produits/modif-produits.html.twig', [
           'modif' => $produits,
           'form' => $form->createView()
        ]);
    }

    #[Route('/supp-produits/{id}', name: 'supp-produits')]
    public function suppProduits(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id=$request->get('id');
        $repoProduits = $entityManagerInterface->getRepository(Produits::class);
        $produits = $repoProduits->find($id);
              
                $entityManagerInterface->remove($produits);
                $entityManagerInterface->flush();

                $this->addFlash('notice','Suppression Terminé');
                return $this->redirectToRoute('liste-produits');

        return $this->render('produits/supp-produits.html.twig', [
           'modif' => $produits,
           'form' => $form->createView()
        ]);
    }

    #[Route('/ajout-produits', name: 'ajout-produits')]
    public function AjoutProduits(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $produits = new Produits();
        $form = $this->createForm(ProduitsType::class, $produits);

        if($request->isMethod('POST')){
            $form->handleRequest($request);
            if ($form->isSubmitted()&&$form->isValid()){
              
                $entityManagerInterface->persist($produits);
                $entityManagerInterface->flush();

                $this->addFlash('notice','Modification réussi');
                return $this->redirectToRoute('liste-produits');
              
            }
        }

        return $this->render('produits/ajout-produits.html.twig', [
           'form' => $form->createView()
        ]);
    }
}