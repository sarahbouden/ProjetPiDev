<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('base-back.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    #[Route('/addclient', name: 'addclient')]
    public function addclient(ManagerRegistry $managerRegistry,Request $request): Response
    {
        $em=$managerRegistry->getManager();
        $Client=new User();
        $form=$this->createForm(UserType::class,$Client);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $Client->setRole('Client');
            $em->persist($Client);
            $em->flush();
        }

        return $this->render('user/addclient.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/addAdmin', name: 'addAdmin')]
    public function addAdmin(ManagerRegistry $managerRegistry,Request $request): Response
    {
        $em=$managerRegistry->getManager();
        $Admin=new User();
        $form=$this->createForm(UserType::class,$Admin);
        $form->handleRequest($request);
        if($form->isSubmitted()&& $form->isValid()){
            $Admin->setRole('Admin');
            $em->persist($Admin);
            $em->flush();
        }

        return $this->render('user/addadmin.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/showUsers', name: 'showUsers')]
    public function showUsers(UserRepository $userRepository): Response
    {
       $DB=$userRepository->findAll();
        return $this->render('user/showUsers.html.twig', [
            'users' => $DB,
        ]);
    }
    #[Route('/updateuser/{id}', name: 'updateuser')]
    public function updateuser($id,ManagerRegistry $managerRegistry,Request $req,UserRepository $ur ): Response
    {
        $em=$managerRegistry->getManager();
        $User=$ur->find($id);
        $form=$this->createForm(UserType::class,$User);
        $form->handleRequest($req);
        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($User);
            $em->flush();
        }
        return $this->renderForm('user/updateUser.html.twig', [
            'f' => $form,
        ]);
    }
    #[Route('/deleteuser/{id}', name: 'deleteuser')]
    public function deleteuser($id,UserRepository $ur,ManagerRegistry $managerRegistry): Response
    {
        $em=$managerRegistry->getManager();
        $idD=$ur->find($id);
        $em->remove($idD);
        $em->flush();
        return $this->redirectToRoute('showUsers');
    }
}
