<?php

namespace App\Controller;

use App\Entity\Hotel;
use App\Form\HotelType;
use App\Repository\HotelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\String\Slugger\SluggerInterface;


class HotelController extends AbstractController
{
   /* #[Route('/hotel', name: 'app_hotel')]
    public function index(): Response
    {
        return $this->render('hotel/index.html.twig', [
            'hotels' => 'HotelController',
        ]);
    }*/

    #[Route('/hotel', name: 'app_hotel',  methods: ['GET'])]
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('hotel/index.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }

   /*#[Route('/showhotel', name: 'showhotel')]
    public function showhotel(HotelRepository $hotelRepository): Response
    {
        $hotel=$hotelRepository->findAll();
        return $this->render('hotel/showhotel.html.twig', [
            'hotels'=>$hotel
        ]);
    }*/

   /*#[Route('/{id}', name: 'showhotel' , methods: ['GET']) ]
   
    public function showhotel($id,Hotel $hotel,HotelRepository $hotels): Response
    {   $hotels = $hotels->find($id);
        return $this->render('hotel/showhotel.html.twig', [
            'hotel'=>$hotel
        ]);
    }*/


    /*#[Route('/{id}/showhotel', name: 'showhotel', methods: ['GET'])]
    public function showhotel($id,HotelRepository $hotels): Response

    {   $hotels = $hotels->find($id);
        return $this->render('hotel/showhotel.html.twig', [
            'hotel'=>$hotels
        ]);
    }*/

   /* #[Route('/{id}', name: 'showhotel', methods: ['GET'])]
    public function show(Hotel $hotel): Response
    {
        return $this->render('hotel/showhotel.html.twig', [
            'hotel' => $hotel,
        ]);
    }*/
    /*#[Route('/showhotel', name: 'showhotel')]
    public function showhotel(HotelRepository $hotel): Response
    {
        return $this->render('hotel/showhotel.html.twig', [
            'hotel'=>$hotel
        ]);
    }*/
    #[Route('/{id}/showhotel', name: 'showhotel', methods: ['GET'])]
    public function showhotel($id,HotelRepository $hotels): Response

    {   $hotels = $hotels->find($id);
        return $this->render('hotel/showhotel.html.twig', [
            'hotels'=>$hotels
        ]);
    }

   
    #[Route('/hotel/hotels', name: 'indexfront', methods: ['GET'])]
    public function indexfront(HotelRepository $hotelRepository): Response
    {
        return $this->render('hotel/indexfront.html.twig', [
            'hotels' => $hotelRepository->findAll(),
        ]);
    }


   
    #[Route('/{id}/showfront', name: 'showfront', methods: ['GET'])]
    public function showfront($id,HotelRepository $hotels): Response

    {   $hotels = $hotels->find($id);
        return $this->render('hotel/showfront.html.twig', [
            'hotels'=>$hotels
        ]);
    }

     /*#[Route('/{id}', name: 'app_activite_show', methods: ['GET'])]
    public function show(Activite $activite): Response
    {
        return $this->render('activite/show.html.twig', [
            'activite' => $activite,
        ]);
    }
    #[Route('/{id}/front', name: 'showfront', methods: ['GET'])]
    public function showfront(Activite $activite): Response
    {
        return $this->render('activite/showfront.html.twig', [
            'activit' => $activite,
        ]);
    }*/
    /*#[Route('/hotel', name: 'app_hotel', methods: ['GET'])]
    public function index(HotelRepository $hotelRepository): Response
    {
        return $this->render('hotel/index.html.twig', [
            'controller_name' => $hotelRepository->findAll(),
        ]);
    
    }*/
 
    
    /* #[Route('/hotel/hotels', name: 'app_hotels')]
    public function indexfront(): Response
    {
        return $this->render('hotel/indexfront.html.twig', [
            'hotels' => 'HotelController',
        ]);
    }*/

    #[Route('/addhotel', name: 'addhotel')]
    public function addhotel(ManagerRegistry $managerRegistry, Request $req): Response
    {
        $em=$managerRegistry->getManager();
        $hotel=new Hotel();
        $form=$this->createForm(HotelType::class,$hotel);
        $form->handleRequest($req);//liaison base de donnees

        if($form->isSubmitted() and $form->isValid()){
        $em->persist($hotel);//bsh ysob les données ml instance
        $em->flush();//pour l'execution
        return $this->redirectToRoute('app_hotel');
        }
        return $this->renderForm('hotel/addhotel.html.twig', [
        'form'=>$form
        ]);
    }


    #[Route('/edithotel/{id}', name: 'edithotel')]
    public function edithotel($id,HotelRepository $hotelRepository,Request $req,ManagerRegistry $managerRegistry): Response
    {         
        $em=$managerRegistry->getManager();
        $dataid=$hotelRepository->find($id);
       // var_dump($id) . die();
        $form=$this->createForm(HotelType::class,$dataid);
        $form->handleRequest($req);

        if($form->isSubmitted() and $form->isValid()){
            $em->persist($dataid);
            $em->flush();

            return $this->redirectToRoute('app_hotel');

        }
        return $this->renderForm('hotel/edithotel.html.twig', [
            'x'=>$form
            ]);

    }

   /* #[Route('/edithotel/{id}', name: 'edithotel')]
    public function edithotel($id, HotelRepository $hotelRepository, Request $req, ManagerRegistry $managerRegistry): Response
    {         
        $entityManager = $managerRegistry->getManager();
    
        $hotel = $hotelRepository->find($id);
    
        if (!$hotel) {
            throw $this->createNotFoundException('L\'hôtel avec l\'identifiant ' . $id . ' n\'a pas été trouvé.');
        }
    
        $form = $this->createForm(HotelType::class, $hotel);
        $form->handleRequest($req);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Pas besoin de persister l'entité car elle est déjà gérée par l'EntityManager
            $entityManager->flush();
    
            return $this->redirectToRoute('showhotel');
        }
    
        return $this->renderForm('hotel/edithotel.html.twig', [
            'x' => $form
        ]);
    }*/

    #[Route('/deletehotel/{id}', name: 'deletehotel')]
    public function deletehotel($id,HotelRepository $hotelRepository, ManagerRegistry $managerRegistry, Request $req): Response
    {
        $emm = $managerRegistry->getManager();
        $idremove = $hotelRepository->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('app_hotel');
    
    }
}