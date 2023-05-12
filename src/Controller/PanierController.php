<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Produits;
use App\Entity\User;
use App\Entity\Panier;
use App\Entity\Ajouter;
use App\Form\ProduitsType;
use App\Form\PanierType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PanierController extends AbstractController
{
    #[Route('/private-panier/{id}', name: 'panier')]
    public function Panier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id=$request->get('id');
        $action = $request->get('action');
        $produits = $entityManagerInterface->getRepository(Produits::class)->find($id);

        if($action=='supprimer'){
            //$this->getUser()->removeAjouter($produits);

            $ajouter = $entityManagerInterface->getRepository(Ajouter::class)->find($id);
            $entityManagerInterface->remove($ajouter);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste-panier');
        }

        if($action=='plus'){
            $ajouter = $entityManagerInterface->getRepository(Ajouter::class)->find($id);
            $ajouter->setQte($ajouter->getQte()+1);
            $entityManagerInterface->persist($ajouter);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste-panier');

        }

        if($action=='moins'){
            $ajouter = $entityManagerInterface->getRepository(Ajouter::class)->find($id);
            $qte = $ajouter->getQte();
            if ($qte>1) {
                $ajouter->setQte($qte-1);
            }
            $entityManagerInterface->persist($ajouter);
            $entityManagerInterface->flush();
            return $this->redirectToRoute('liste-panier');
        }

        

        if($action=='ajouter'){

            if ($this->getUser()->getPanier()==null){
                $panier = new Panier();
                $this->getUser()->setPanier($panier);
                $entityManagerInterface->persist($panier);
            }

            
            $ajouter = new Ajouter();
            $ajouter->setProduits($produits);
            $ajouter->setPanier($this->getUser()->getPanier());
            $ajouter->setQte(1);
            $entityManagerInterface->persist($ajouter);
            $this->getUser()->getPanier()->addAjouter($ajouter);
        }      
                $entityManagerInterface->persist($this->getUser());
                $entityManagerInterface->flush();
                return $this->render('panier/index.html.twig', [
                    'produits' => $produits
                 ]);
       
    }

    
    #[Route('/liste-panier', name: 'liste-panier')]
    public function listePanier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        if ($this->getUser()->getPanier() == null){
            return $this->render('panier/panier-vide.html.twig', [
           
            ]);
        }else{
        return $this->render('panier/liste-panier.html.twig', [
           
        ]);
        }
    }

     
    #[Route('/supp-panier/{id}', name: 'supp-panier')]
    public function suppPanier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id=$request->get('id');
        $repoPanier = $entityManagerInterface->getRepository(Panier::class);
        $panier = $repoPanier->find($id);
        $repoAjouter = $entityManagerInterface->getRepository(Ajouter::class);
        $ajouter = $repoAjouter->find($id);
              
                $entityManagerInterface->remove($ajouter);
                $entityManagerInterface->flush();

                $this->addFlash('notice','Suppression Terminé');
                return $this->redirectToRoute('liste-panier');

        return $this->render('panier/supp-panier.html.twig', [
           'modif' => $produits,
           'form' => $form->createView()
        ]);
    }
        

    #[Route('/private-ajout-panier', name: 'ajout-panier')]
    public function AjoutPanier(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $idProduit = $request->get('id');
        $page=$request->get('page');
        if($this->getUser()->getPanier()==null){
            $panier=New Panier();
            $this->getUser()->setPanier($panier);
        }

        // id = 5
        // panier = [Ajouter id = 1 -> produit id = 5, Ajouter id = 2  -> produit id = 7,...]

        $isDejaCreer = false;

        // vérif
        foreach ($this->getUser()->getPanier()->getAjouters() as $unAjouter) {
            if ($unAjouter->getProduits()->getId() == $idProduit) {
                $isDejaCreer = true;
                $unAjouter->setQte($unAjouter->getQte()+1);
                $entityManagerInterface->persist($unAjouter);
            }
        }

        if ($isDejaCreer == false) {
            $produits = $entityManagerInterface->getRepository(Produits::class)->find($idProduit);
            $ajouter = new Ajouter();
            $ajouter->setQte(1);
            $ajouter->setProduits($produits);
            $ajouter->setPanier($this->getUser()->getPanier());
            $entityManagerInterface->persist($ajouter);
            $this->getUser()->getPanier()->addAjouter($ajouter);
            $entityManagerInterface->persist($this->getUser());
            $entityManagerInterface->persist($ajouter);
        }       
        $entityManagerInterface->flush();

                return $this->redirectToRoute($page);
    }


    #[Route('/private-acheter/{id}', name: 'acheter')]
    public function Acheter(EntityManagerInterface $entityManagerInterface,Request $request): Response
    {
        $id = $request->get('id');
        $produits = $entityManagerInterface->getRepository(Produits::class)->find($id);
        return $this->render('panier/acheter.html.twig', [
           'produits' => $produits,
        ]);
    }

    #[Route('/achatpanier', name: 'achatpanier')]
    public function achapanier(EntityManagerInterface $entityManagerInterface): Response
    {
        foreach ($this->getUser()->getPanier()->getAjouters() as $unAjouter) {
            $entityManagerInterface->remove($unAjouter);
        } 
        $entityManagerInterface->flush();
        return $this->render('panier/achatconf.html.twig', [
        
        ]);
    }
    #[Route('/achatconf', name: 'achatconf')]
    public function mentions(EntityManagerInterface $entityManagerInterface): Response
    {
        $entityManagerInterface->flush();
        return $this->render('panier/achatconf.html.twig', [
        
        ]);
    }
}