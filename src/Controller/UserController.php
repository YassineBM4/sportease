<?php

namespace App\Controller;

use App\Form\EditUserType;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function home(): Response
    {
        return $this->render('user/home.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/aboutUs', name: 'aboutUs')]
    public function aboutUs(): Response
    {
        return $this->render('user/aboutUs.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/schedule', name: 'schedule')]
    public function schedule(): Response
    {
        return $this->render('user/schedule.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/gallery', name: 'gallery')]
    public function gallery(): Response
    {
        return $this->render('user/gallery.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/blog', name: 'blog')]
    public function blog(): Response
    {
        return $this->render('user/blog.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/contact', name: 'contact')]
    public function contact(): Response
    {
        return $this->render('user/contact.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    #[Route('/profile', name: 'profile')]
    public function profile(UserRepository $userRepository): Response
    {
        $user=$userRepository->findAll();
        return $this->render('user/profile.html.twig', [
            'table' =>$user
        ]);
    }

    #[Route('/editProfile', name: 'editProfile')]
    public function editProfile(UserRepository $userRepository, ManagerRegistry $managerRegistry, Request $request): Response
    {
        $m=$managerRegistry->getManager();
        $findid=$this->getUser();
        $form=$this->createForm(EditUserType::class,$findid);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $m->persist($findid);
            $m->flush();

            return $this->redirectToRoute('profile');
        }
        return $this->render('user/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

}
