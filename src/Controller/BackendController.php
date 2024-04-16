<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BackendController extends AbstractController
{
    #[Route('/backendHome', name: 'backendHome')]
    public function backendHome(UserRepository $userRepository): Response
    {
        $user=$userRepository->findAll();
        return $this->render('backend/home.html.twig', [
            'table' => $user
        ]);
    }

    # BACKEND CRUD

    #[Route('/UsersList', name: 'UsersList')]
    public function UsersList(UserRepository $userRepository): Response
    {
        $user=$userRepository->findAll();
        return $this->render('backend/list.html.twig', [
            'table' => $user
        ]);
    }

    #[Route('/adminProfile', name: 'adminProfile')]
    public function adminProfile(UserRepository $userRepository): Response
    {
        $user=$userRepository->findAll();
        return $this->render('backend/profile.html.twig', [
            'table' => $user
        ]);
    }

    #[Route('/editMyProfile', name: 'editMyProfile')]
    public function editMyProfile(UserRepository $userRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$this->getUser();
        $form=$this->createForm(EditUserType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('adminProfile');
        }
        return $this->render('backend/editMyProfile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/editUser/{id}', name: 'editUser')]
    public function editUser(UserRepository $userRepository, ManagerRegistry $managerRegistry, Request $request,$id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$userRepository->find($id);
        $form=$this->createForm(EditUserType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('UsersList');
        }
        return $this->render('backend/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/deleteProfile/{id}', name: 'deleteProfile')]
    public function deleteProfile(UserRepository $userRepository, ManagerRegistry $managerRegistry, $id): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$userRepository->find($id);
        $m->remove($findid);
        $m->flush();
        return $this->redirectToRoute('backendHome');
    }
}
