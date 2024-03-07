<?php

namespace App\Controller;

use App\Entity\Publication;
use App\Form\PublicationType;
use App\Repository\PublicationRepository;
use App\Service\SmsGenerator;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Filesystem\Filesystem;

#[Route('/publication')]
class PublicationController extends AbstractController
{

    #[Route('/', name: 'app_publication_index', methods: ['GET'])]
    public function index(PublicationRepository $publicationRepository) : Response
    {
        $publications = $publicationRepository->findAll();

        return $this->render('publication/index.html.twig', [
            'publications' => $publications,
        ]);
    }
    #[Route('/rate-publication', name: 'app_rate-publication')]
    public function ratePublication(Request $request, PublicationRepository $publicationRepository, EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);
        $publicationId = $data['publicationId'];
        $ratingValue = $data['ratingValue'];
        $publication = $publicationRepository->findOneBy(['id' => $publicationId]);
        if ($publication) {
            $publication->setSomme($publication->getSomme() + 1);
            $publication->setRating($publication->getRating() + $ratingValue);
            $entityManager->flush();
            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return new Response('Publication not found', Response::HTTP_NOT_FOUND);
        }
    }

    #[Route('/new', name: 'app_publication_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager,SmsGenerator $smsGenerator  ): Response
    {

        $suc=false;
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form['UrlRessource']->getData();

            // Check if a file was uploaded
            if ($uploadedFile) {
                // Get the original file name
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // Generate a unique name for the file
                $newFilename = $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension();


                    $uploadedFile->move(
                        $this->getParameter('uploaded_files_directory'), // Specify the directory where you want to store the file
                        $newFilename
                    );



                $publication->setUrlRessource($newFilename);
            }
            $entityManager->persist($publication);
            $entityManager->flush();
            $smsGenerator->sendSms('+21692523032' ,'felicitation votre publication a ete cree avec succes!');



            $suc=true;
            return $this->renderForm('publication/new.html.twig', [
                'publication' => $publication,
                'form' => $form,
                'suc'=>$suc,
            ]);
        }

        return $this->renderForm('publication/new.html.twig', [
            'publication' => $publication,
            'form' => $form,
            'suc'=>$suc,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_show', methods: ['GET'])]
    public function show(Publication $publication): Response
    {
        return $this->render('publication/show.html.twig', [
            'publication' => $publication,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_publication_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        $filesystem = new Filesystem();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $uploadedFile = $form->get('PhotoURL')->getData();
            $formData = $uploadedFile->getPathname();
            $sourcePath = strval($formData);
            $destinationPath = 'pictures'.$publication->getTitre().strval($publication->getId()).'.png';
            $publication->setUrlRessource($destinationPath);
            $filesystem->copy($sourcePath,$destinationPath);

            
            $entityManager->flush();

            return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('publication/edit.html.twig', [
            'publication' => $publication,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_publication_delete', methods: ['POST'])]
    public function delete(Request $request, Publication $publication, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publication->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publication);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_publication_index', [], Response::HTTP_SEE_OTHER);
    }
}
