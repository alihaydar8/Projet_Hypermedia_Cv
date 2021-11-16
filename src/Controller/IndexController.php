<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('index/home.html.twig');
    }
    /**
     * @Route("/competence", name="competence")
     */
    public function competence(): Response
    {
        return $this->render('index/competence.html.twig');
    }

    /**
     * @Route("/experience", name="experience")
     */
    public function experience(): Response
    {
        return $this->render('index/experience.html.twig');
    }
    
    /**
     * @Route("/formation", name="formation")
     */
    public function formation(): Response
    {
        return $this->render('index/formation.html.twig');
    }
}
