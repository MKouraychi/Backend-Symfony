<?php

namespace App\Controller;
use App\Entity\Activite;
use App\Form\ActiviteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ActiviteRepository;
class ActiviteController extends AbstractController
{
    /**
     * @Route("/activite", name="activite")
     */
    public function index(): Response
    {
        return $this->render('activite/index.html.twig', [
            'controller_name' => 'ActiviteController',
        ]);
    }
    /**
     * @Route("showactivity" ,name="showactivity")
     */
    public function showactivities(ActiviteRepository $activity):Response 
    {
        return $this->render('activite/showall.html.twig',['activite'=>$activity->findAll()]);
    }
    /**
     * @Route("/newActivite", name="newActivite")
     */
    public function new(Request $request, EntityManagerInterface $entityManager):Response 
    {
        $Activite= new Activite();
        $form= $this->createForm(ActiviteType::class,$Activite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Activite);
            $entityManager->flush();

            return $this->redirectToRoute('showactivity', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activite/new.html.twig', [
            
            'form' => $form->createView(),
        ]);

    }
    /**
     * @Route("/deleteAct/{id}" , name="deleteAct")
     */
    public function deleteAct($id,EntityManagerInterface $entityManager,ActiviteRepository $activity) : Response
    {
        $dest= $activity->find($id);
        $entityManager->remove($dest);
        $entityManager->flush();
        return $this->redirectToRoute('showactivity', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/updateAct/{id}", name="updateAct")
     */
    public function updateAct($id,EntityManagerInterface $entityManager,ActiviteRepository $activity,Request $request) :Response
    {
        $dest= $activity->find($id);
        $form= $this->createForm(ActiviteType::class,$dest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dest);
            $entityManager->flush();

            return $this->redirectToRoute('showactivity', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('activite/updatedest.html.twig', [
            
            'form' => $form->createView(),
        ]);

    }
}
