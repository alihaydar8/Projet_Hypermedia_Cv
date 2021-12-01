<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Competence;
use App\Entity\Experience;
use App\Form\FormationType;
use App\Form\CompetenceType;
use App\Form\ExperienceType;
use App\Repository\FormationRepository;
use App\Repository\CompetenceRepository;
use App\Repository\ExperienceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function competence(CompetenceRepository $competenceRepository): Response
    {
        return $this->render( 'index/competence.html.twig', ['competences' => $competenceRepository->findAll()]);
    }

    /**
     * @Route("/experience", name="experience")
     */
    public function experience(ExperienceRepository $experienceRepository): Response
    {
        return $this->render( 'index/experience.html.twig', ['experiences' => $experienceRepository->findAll()]);
    }
    
    /**
     * @Route("/formation", name="formation")
     */
    public function formation(FormationRepository $formationRepository): Response
    {
        return $this->render('index/formation.html.twig',['formations' =>$formationRepository->findAll()]);
    }

    /**
     * @Route("/competence/add/", name="competence_add")
     * @Route("/competence/{id}/edit", name="competence_edit")
     */
    public function addCompetence(competence $competence=null,  Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($competence==null)
        $competence = new Competence();


        $form = $this->createForm(CompetenceType::class, $competence);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($competence);
            $manager->flush();
            return $this->redirectToRoute('competence');
        }

        return $this->render('index/addCompetence.html.twig', [
            'form' => $form->createView(),'editmode'=>$competence->getId() !== null
        ]);
    }

    /**
     * @Route("/experience/add/", name="experience_add")
     * @Route("/experience/{id}/edit", name="experience_edit")
     */
    public function addExperience(Experience $experience=null,  Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if($experience==null)
        $experience = new Experience();


        $form = $this->createForm(ExperienceType::class, $experience);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($experience);
            $manager->flush();
            return $this->redirectToRoute('experience');
        }

        return $this->render('index/addExperience.html.twig', [
            'form' => $form->createView(),'editmode'=>$experience->getId() !== null
        ]);
    }

    /**
     * @Route("/formation/add/", name="formation_add")
     * @Route("/formation/{id}/edit", name="formation_edit")
     */
    public function addFormation(Formation $formation=null, Request $request, EntityManagerInterface $manager)
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if($formation==null)
        $formation = new Formation();


        $form = $this->createForm(FormationType::class, $formation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($formation);
            $manager->flush();
            return $this->redirectToRoute('formation');
        }

        return $this->render('index/addFormation.html.twig', [
            'form' => $form->createView(),'editmode'=>$formation->getId() !== null
        ]);
    }
}