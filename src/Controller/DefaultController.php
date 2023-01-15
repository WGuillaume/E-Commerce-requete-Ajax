<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\MotoRepository;
use App\Repository\PanierRepository;
use App\Repository\MotoPanierRepository;
use Symfony\Component\HttpFoundation\Request;
use Datetime;
use App\Entity\Panier;
use App\Entity\MotoPanier;



class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(MotoRepository $motoRepository): Response
    {
        return $this->render('default/index.html.twig', [
            'motos'=>$motoRepository->findAll()
            
        ]);
    }

    
    /**
     * @Route("/ajaxAddPanier", name="ajaxAddPanier")
     */
    public function ajaxAddPanier(Request $request, MotoRepository $motosRepository, PanierRepository $panierRepo, MotoPanierRepository $motosPanierRepo): Response
    {
        $idMoto = $_POST['id'];
        $moto = $motosRepository->findOneById($idMoto);
        $qte = $_POST['quantite'];
        $prixUnit = $moto->getPrix();
        $total = $qte*$prixUnit;

        $panierUser = $panierRepo->findOneBy(['userpanier'=>$this->getUser()]);

        // Je vérifie si le user a déjà un panier
        if(empty($panierUser))
        {
            $panier = new Panier();
            $panier->setUserpanier($this->getUser());
            $panier->setDate(new Datetime());
            $panier->setTotal(0);
            $panier->setEtat(0);
            $panierRepo->add($panier, true);
        }
        else
        {
        $panier = $panierUser;
        }

        // J'ajoute le produit dans le panier

        // je verifie si le produit existe deja dans le panier
        // Si oui je mets a jour la qte sinon je l'ajoute

        $motosPanier = $motosPanierRepo->findOneBy(['Moto'=>$idMoto,'Panier'=>$panier]);

        if(!empty($motosPanier))
        {
            $qteExist = $motosPanier->getQuantite();
            $newQte = $qte+$qteExist;
            $sousTotal = $newQte*$prixUnit;

            $motosPanier->setQuantite($newQte);
            $motosPanier->setTotal($sousTotal);

            $motosPanierRepo->add($motosPanier, true);
        }
        else
        { 
            $produit = new MotoPanier();
            $produit->setMoto($moto);
            $produit->setPanier($panier);
            $produit->setQuantite($qte);
            $produit->setTotal($total);
            $motosPanierRepo->add($produit, true);
        }

        // je mets a jour le total du panier

        $motosPaniers = $motosPanierRepo->findBy(['Panier'=>$panier]);

        $sum = 0;

        foreach($motosPaniers as $res)
        {
            $sum = $sum + $res->getTotal();
        }

        $panier->setTotal($sum);
        $panierRepo->add($panier, true);

        $message = 'Le produit a bien été ajouté au panier';

        return new Response($message);
        

    }

    
    /**
     * @Route("/ajaxRecapPanierHeader", name="ajaxRecapPanierHeader")
     */
    public function ajaxRecapPanierHeader(Request $request, MotoRepository $motosRepository, PanierRepository $panierRepo, MotoPanierRepository $motosPanierRepo): Response
    {
        $panierUser = $panierRepo->findOneBy(['userpanier'=>$this->getUser()]);

        if(!empty($panierUser))
        {
            $qte = 0;           
            foreach($panierUser->getMotoPaniers() as $res)
            {
                $qte = $qte+$res->getQuantite();
            }

            
            $total = $panierUser->getTotal();
        }
        else
        {
            $qte = 0;
            $total = 0;
        }
        $chaine = ' <button type="button" class="btn btn-primary position-relative"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart" viewBox="0 0 16 16">
        <path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
    </svg>
        Panier <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-secondary">'.$qte.' <span class="visually-hidden">unread messages</span></span>
    </button>';


        return new Response($chaine);
    }
    /**
     * @Route("/ajaxRecapPanier", name="ajaxRecapPanier")
     */
    public function ajaxRecapPanier(Request $request, MotoRepository $motosRepository, PanierRepository $panierRepo, MotoPanierRepository $motosPanierRepo): Response
    {
        $panierUser = $panierRepo->findOneBy(['userpanier'=>$this->getUser()]);

        if(!empty($panierUser))
        {
            $qte = 0;          
            foreach($panierUser->getMotoPaniers() as $res)
            {
                $qte = $qte+$res->getQuantite();
            }

            
            $total = $panierUser->getTotal();
        }
        else
        {
            $qte = 0;
            $total = 0;
        }


        return new Response($total);
    }
    /**
     * @Route("/ajaxMinMaxPanier", name="ajaxMinMaxPanier")
     */
    public function ajaxMinMaxPanier(Request $request, MotoRepository $motosRepository, PanierRepository $panierRepo, MotoPanierRepository $motosPanierRepo): Response
    {
        $motosPanier = $motosPanierRepo->findOneBy(['id'=>$_POST['id']]);
        $quantite = $_POST['quantite'];
        $total=$quantite*$motosPanier->getMoto()->getPrix();

        $motosPanier->setQuantite($quantite);
        $motosPanier->setTotal($total);
        $motosPanierRepo->add($motosPanier, true);

        $panierUser = $panierRepo->findOneBy(['id'=>$motosPanier->getPanier()]);

        $motosPaniers = $motosPanierRepo->findBy(['Panier'=>$motosPanier->getPanier()]);
        $totals=0;
        foreach($motosPaniers as $res)
        {
            $totals = $totals+$res->getTotal();
        }

        // Je vérifie si le user a déjà un panier
    
            $panierUser->setTotal($totals);
            
            $panierRepo->add($panierUser, true);
    
        return new Response($total);    
    }
    /**
     * @Route("/ajaxDelPanier/{id}", name="ajaxDelPanier")
     */
    public function ajaxDelPanier(Request $request, MotoPanierRepository $motosPanierRepo,PanierRepository $panierRepo,$id): Response
    {
        $motosPanier = $motosPanierRepo->findOneBy(['id'=>$id]);
        $motosPanierRepo->remove($motosPanier, true);

        $panierUser = $panierRepo->findOneBy(['id'=>$motosPanier->getPanier()]);
        $motosPaniers = $motosPanierRepo->findBy(['Panier'=>$motosPanier->getPanier()]);
        $totals=0;
        foreach($motosPaniers as $res)
        {
            $totals = $totals+$res->getTotal();
        }

        // Je vérifie si le user a déjà un panier
    
            $panierUser->setTotal($totals);
            
            $panierRepo->add($panierUser, true);
        return $this->redirectToRoute('app_panier', [], Response::HTTP_SEE_OTHER);
        }
        

    
}

    