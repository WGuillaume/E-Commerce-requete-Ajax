<?php

namespace App\Controller;

use App\Entity\Photo;
use App\Form\PhotoType;
use App\Repository\PhotoRepository;
use App\Repository\MotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/photo")
 */
class PhotoController extends AbstractController
{
    /**
     * @Route("/{id}", name="app_photo_index", methods={"GET"})
     */
    public function index(PhotoRepository $photoRepository,$id): Response
    {
        return $this->render('photo/index.html.twig', [
            'photos' => $photoRepository->findBy(['Moto'=>$id]),
            'id'=>$id
        ]);
    }

    /**
     * @Route("/new/{id}", name="app_photo_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PhotoRepository $photoRepository,MotoRepository $motoRepository,$id): Response
    {
        
        $photo = new Photo();
        $moto=$motoRepository->findOneById($id);
        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file=$form->get('lien')->getData();
                if($file !='null')
                {
                    //je definit le dossier de destination
                    $path='/';
                    // je definit le nom final de l'image
                    $filename=uniqid().'.'.$file->guessExtension();
                    //upload de l'image dans le dpssier public photo
                    $file->move($this->getParameter('photo_directory').$path,$filename

                );
                //je stock le liens dans le bdd photo
                $photo->setlien($filename);
                }
                $photo->setMoto($moto);
            
            $photoRepository->add($photo, true);

            return $this->redirectToRoute('app_photo_index', ['id'=>$id], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('photo/new.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_photo_show", methods={"GET"})
     */
    public function show(Photo $photo): Response
    {
        return $this->render('photo/show.html.twig', [
            'photo' => $photo,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_photo_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    {   $imageExit=$photo->getlien();

        $form = $this->createForm(PhotoType::class, $photo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file=$form->get('lien')->getData();
                if($file !='null')
                {
                    // je suprimme l'mage  existante
                    $lienImageExist = '../public/photo/'.$imageExit;
                    if(file_exists($lienImageExist))
                    {
                        unlink($lienImageExist);
                    }
                    //je definit le dossier de destination
                    $path='/';
                    // je definit le nom final de l'image
                    $filename=uniqid().'.'.$file->guessExtension();
                    //upload de l'image dans le dpssier public photo
                    $file->move($this->getParameter('photo_directory').$path,$filename

                );
                //je stock le liens dans le bdd photo
                $photo->setlien($filename);
                }
            $photoRepository->add($photo, true);

            return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('photo/edit.html.twig', [
            'photo' => $photo,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_photo_delete", methods={"POST"})
     */
    public function delete(Request $request, Photo $photo, PhotoRepository $photoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$photo->getId(), $request->request->get('_token'))) {
            $photoRepository->remove($photo, true);
        }

        return $this->redirectToRoute('app_photo_index', [], Response::HTTP_SEE_OTHER);
    }
}
