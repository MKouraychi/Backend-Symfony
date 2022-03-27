<?php

namespace App\Controller;
use App\Entity\Activite;
use App\Entity\Destination;
use App\Entity\Offre;
use App\Form\OffreType;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\OffreRepository;
use Symfony\Component\Security\Core\Security;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="offre")
     */
    public function index(): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }
    /**
     * @Route("/showalloffre", name="showalloffre")
     */
    public function ShowAll(OffreRepository $OffreRepository, PaginatorInterface $paginator,Request $request): Response
    {
        $of=$OffreRepository->findAll();
        $offres=$paginator->paginate($of,$request->query->getInt('page',1),2);
        return $this->render('offre/showAll.html.twig',['Offres'=> $offres]);

    }
    /**
     * @Route("/showalloffrefront", name="showalloffrefront")
     */
    public function showalloffrefront(OffreRepository $OffreRepository): Response
    {
        $of=$OffreRepository->findAll();

        return $this->render('offre/showalloffrefront.html.twig',['Offres'=> $of]);

    }
    /**
     * @Route("/showalloffrefront3", name="showalloffrefront3")
     */
    public function showalloffrefront3(OffreRepository $OffreRepository): Response
    {
        $of=$OffreRepository->findBy(array(),array('nbdevues'=>'ASC'));

        return $this->render('offre/showalloffrefront.html.twig',['Offres'=> $of]);

    }
    /**
     * @Route("/newOffre", name="newOffre")
     */
    public function new(Request $request, EntityManagerInterface $entityManager):Response 
    {
        $Offre= new Offre();
        $form= $this->createForm(OffreType::class,$Offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $file=$form->get('image')->getData();
            $filename=md5(uniqid()).'.'.$file->guessExtension();
            $file->move(
                $this->getParameter('image_directory'),$filename
            );
            $Offre->setImage($filename);
            $Offre->setNbdevues(0);
            $entityManager->persist($Offre);
            $entityManager->flush();

            return $this->redirectToRoute('showalloffre', [], Response::HTTP_SEE_OTHER);
        }
        $destinations = $this->getDoctrine()->getManager()->getRepository(Destination::class)->findAll();
        $activites= $this->getDoctrine()->getManager()->getRepository(Activite::class)->findAll();
        return $this->render('offre/new.html.twig', [
            
            'form' => $form->createView(),'destinations'=>$destinations, 'activites'=>$activites
        ]);

    }

    /**
     * @Route("/deleteOffre/{id}", name="deleteOffre")
     */
    public function deleteOffre($id,OffreRepository $OffreRepository, EntityManagerInterface $entityManager) : Response
    {
        $Offre=$OffreRepository->find($id);
        $entityManager->remove($Offre);
        $entityManager->flush();
        return $this->redirectToRoute('showalloffre', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/updateOffre/{id}",name="updateOffre")
     */
    public function updateOffre($id,OffreRepository $OffreRepository, EntityManagerInterface $entityManager,Request $request) :Response
    {
        $Offre=$OffreRepository->find($id);
        $form= $this->createForm(OffreType::class,$Offre);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($Offre);
            $entityManager->flush();

            return $this->redirectToRoute('showalloffre', [], Response::HTTP_SEE_OTHER);
        }
        return $this->render('offre/updateOffre.html.twig', [
            
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/showOne/{id}",name="showOne")
     */
    public function getOneOffre($id) : Response
    {
        $offre=$this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
        return $this->render('offre/showOne.html.twig',['offre'=> $offre]);
    }
    /**
     * @Route("/showOnefront/{id}",name="showOnefront")
     */
    public function getOneOffrefront($id) : Response
    {
        $offre=$this->getDoctrine()->getManager()->getRepository(Offre::class)->find($id);
        return $this->render('offre/showOnefront.html.twig',['offre'=> $offre]);
    }


    /**
     * @Route("/nbvues/{id}",name="nbvues")
     */
    public function addnbvue($id) : Response
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository(Offre::class)->find($id);
        $offre->setNbdevues($offre->getNbdevues()+1);
        $em->persist($offre);
        $em->flush();
        return $this->render('offre/showOnefront.html.twig',['offre'=>$offre]);
    }
    /**
     * @Route("participate/{id}",name="participate")
     */
    public function participate($id,Security $security):Response
    {
        $em=$this->getDoctrine()->getManager();
        $offre=$em->getRepository(Offre::class)->find($id);
        $user = $security->getUser();
        $offre->addUser($user);
        $em->persist($offre);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('showalloffrefront', [], Response::HTTP_SEE_OTHER);
    }
}
