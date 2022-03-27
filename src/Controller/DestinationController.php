<?php

namespace App\Controller;
use App\Entity\Destination;
use App\Form\DestinationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\DestinationRepository;
class DestinationController extends AbstractController
{
    /**
     * @Route("/destination", name="destination")
     */
    public function index(): Response
    {
        return $this->render('destination/index.html.twig', [
            'controller_name' => 'DestinationController',
        ]);
    }
    /**
     * @Route("/showallDestinations", name="showallDestinations")
     */
    public function ShowAll(DestinationRepository $DestinationRepository): Response
    {
        
        return $this->render('destination/showAll.html.twig',['destionations'=>$DestinationRepository->findAll()]);

    }
    /**
     * @Route("/newDestionation", name="newDestination")
     */
    public function new(Request $request, EntityManagerInterface $entityManager):Response 
    {
        $destination= new Destination();
        $form= $this->createForm(DestinationType::class,$destination);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$filename
            );
            $destination->setImage($filename);
            $entityManager->persist($destination);
            $entityManager->flush();

            return $this->redirectToRoute('showallDestinations', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('destination/new.html.twig', [
            
            'form' => $form->createView(),
        ]);

    }
    /**
     * @Route("/deleteDest/{id}" , name="deleteDest")
     */
    public function deleteDest($id,EntityManagerInterface $entityManager,DestinationRepository $DestinationRepository) : Response
    {
        $dest= $DestinationRepository->find($id);
        $entityManager->remove($dest);
        $entityManager->flush();
        return $this->redirectToRoute('showallDestinations', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/updateDest/{id}", name="updateDest")
     */
    public function updateDest($id,EntityManagerInterface $entityManager,DestinationRepository $DestinationRepository,Request $request) :Response
    {
        $dest= $DestinationRepository->find($id);
        $form= $this->createForm(DestinationType::class,$dest);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($dest);
            $entityManager->flush();

            return $this->redirectToRoute('showallDestinations', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('destination/updatedest.html.twig', [
            
            'form' => $form->createView(),
        ]);
    }
}
