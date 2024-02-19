<?php

namespace App\Controller;

use App\Entity\Partenaire;
use App\Form\PartenaireType;
use App\Repository\PartenaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartenaireController extends AbstractController
{
    #[Route('/user/partenaire', name: 'app_partenaire_index', methods: ['GET'])]
    public function index(PartenaireRepository $partenaireRepository): Response
    {
        return $this->render('partenaire_Backend/index.html.twig', [
            'partenaires' => $partenaireRepository->findAll(),
        ]);
    }

    #[Route('/user/partenaire/new', name: 'app_partenaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $partenaire = new Partenaire();
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($partenaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('/partenaire_Backend/new.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

    #[Route('/user/partenaire/{id}', name: 'app_partenaire_show', methods: ['GET'])]
    public function show(Partenaire $partenaire): Response
    {
        return $this->render('partenaire_Backend/show.html.twig', [
            'partenaire' => $partenaire,
        ]);
    }

    #[Route('/user/partenaire/{id}/edit', name: 'app_partenaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Partenaire $partenaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PartenaireType::class, $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('partenaire_Backend/edit.html.twig', [
            'partenaire' => $partenaire,
            'form' => $form,
        ]);
    }

    #[Route('/user/partenaire/delete{id}', name: 'app_partenaire_delete', methods: ['POST'])]
    public function delete(Request $request, Partenaire $partenaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$partenaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($partenaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_partenaire_index', [], Response::HTTP_SEE_OTHER);
    }

#[Route('/partenaire', name: 'partenaire_display')]
    public function display(PartenaireRepository $partenaireRepository): Response
    {
        $partenaires = $partenaireRepository->findAll();

        return $this->render('partenaire-Frontend/partenaire.html.twig', [
            'partenaires' => $partenaires,
        ]);
    }
}