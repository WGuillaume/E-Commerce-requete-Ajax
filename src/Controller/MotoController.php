<?php

namespace App\Controller;

use App\Entity\Moto;
use App\Form\MotoType;
use App\Repository\MotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @Route("/moto")
 * @IsGranted("ROLE_ADMIN")
 */
class MotoController extends AbstractController
{
    /**
     * @Route("/", name="app_moto_index", methods={"GET","POST"})
     */
    public function index(MotoRepository $motoRepository,PaginatorInterface $paginator, Request $request): Response
    {
        //je recupere la variable form

        if(!empty($_POST['search']))
        {
            //j'excute ma requete avec le parametre de recherche
            $donnees=$motoRepository->findByExampleField($_POST['search']);  
        }
        else
        {
            //j'execute ma recherche sans parametre de recherche
            $donnees=$motoRepository->findAll();
        }    

        $pagination=$paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),1 
        );
        return $this->render('moto/index.html.twig', [
            'moto' =>$pagination,

            
        ]);
    }

    /**
     * @Route("/new", name="app_moto_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MotoRepository $motoRepository): Response
    {
        $moto = new Moto();
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motoRepository->add($moto, true);
            
            return $this->redirectToRoute('app_moto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moto/new.html.twig', [
            'moto' => $moto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_moto_show", methods={"GET"})
     */
    public function show(Moto $moto): Response
    {
        return $this->render('moto/show.html.twig', [
            'moto' => $moto,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_moto_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Moto $moto, MotoRepository $motoRepository): Response
    {
        $form = $this->createForm(MotoType::class, $moto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $motoRepository->add($moto, true);

            return $this->redirectToRoute('app_moto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('moto/edit.html.twig', [
            'moto' => $moto,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_moto_delete", methods={"POST"})
     */
    public function delete(Request $request, Moto $moto, MotoRepository $motoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$moto->getId(), $request->request->get('_token'))) {
            $motoRepository->remove($moto, true);
        }

        return $this->redirectToRoute('app_moto_index', [], Response::HTTP_SEE_OTHER);
    }
}
