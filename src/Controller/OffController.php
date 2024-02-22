<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\Offre1Type;
use App\Repository\OffreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;



class OffController extends AbstractController
{
    #[Route('admin/offre/', name: 'app_off_index', methods: ['GET'])]
    public function index(OffreRepository $offreRepository): Response
    {
        return $this->render('back/offre/offres.html.twig', [
            'offres' => $offreRepository->findAll(),
        ]);
    }
   
    

    #[Route('admin/offre/new', name: 'app_off_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $offre = new Offre();
        $filesystem = new Filesystem();
        $form = $this->createForm(Offre1Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $uploadedFile = $form->get('PhotoURL')->getData();
            $formData = $uploadedFile->getPathname();
            $sourcePath = strval($formData);
            $destinationPath = 'uploads/pictures/'.$offre->getNomOffre().strval($offre->getId()).'.png';
            $offre->setPhotoURL($destinationPath);
            $filesystem->copy($sourcePath,$destinationPath);


            $entityManager->persist($offre);
            $entityManager->flush();

            return $this->redirectToRoute('app_off_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/offre/add-offre.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('admin/offre/{id}', name: 'app_off_show', methods: ['GET'])]
    public function show(Offre $offre): Response
    {
        return $this->render('back/offre/offre-detail.html.twig', [
            'offre' => $offre,
        ]);
    }

    #[Route('admin/offre/{id}/edit', name: 'app_off_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        $filesystem = new Filesystem();
        $form = $this->createForm(Offre1Type::class, $offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->flush();

            return $this->redirectToRoute('app_off_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('back/offre/edit-offre.html.twig', [
            'offre' => $offre,
            'form' => $form,
        ]);
    }

    #[Route('admin/offre/{id}', name: 'app_off_delete', methods: ['POST'])]
    public function delete(Request $request, Offre $offre, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$offre->getId(), $request->request->get('_token'))) {
            $entityManager->remove($offre);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_off_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/offre', name: 'offre_display')]
    public function display(OffreRepository $OffreRepository): Response
    {
        $offres = $OffreRepository->findAll();

        return $this->render('front/Offre/offre.html.twig', [
            'offres' => $offres,
        ]);
    }

 
    
  



    
}
