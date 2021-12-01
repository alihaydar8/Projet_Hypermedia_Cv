<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class SecurityController extends AbstractController
{
    #[Route('/login', name: 'security_login')]
    
    public function login ()
    {
        return $this->render('security/login.html.twig');
    }

    #[Route('/logout', name: 'security_logout')]
    public function logout()
    {
    }
    #[Route('/registration', name: 'security_registration')]
    public function signin(UserPasswordEncoderInterface $encoder,Request $request): Response
    {
        $user = new User;
        $form = $this->createForm(RegistrationType::class,$user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
        $entityManager = $this->getDoctrine()->getManager();
        $hash=$encoder->encodePassword($user,$user->getPassword());
        $user->setPassword($hash);
        $entityManager->persist($user);
        $entityManager->flush();
        return $this->redirectToRoute('security_login');
        }

        return $this->render('security/registration.html.twig',['form'=>$form->createView()]);
    }
}