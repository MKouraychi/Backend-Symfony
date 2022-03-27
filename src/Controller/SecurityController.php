<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;

use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/Home/user", name="security_home")
     */
    public function index(): Response
    {
        return $this->render('base.html.twig');
    }
    /**
     * @Route("/inscription", name="security_inscription")
     */
    public function registration(Request $request,UserPasswordEncoderInterface $encoder):Response
    {
        $entityManager=$this->getDoctrine()->getManager();
        $user = new User();
        $user->setRole(false);
        $user->setUsername('Test');
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('security_login');
        }
        return $this->render('security/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/login", name="security_login" , methods={"GET","POST"})
     * @param AuthenticationUtils $authenticationUtils
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function login(AuthenticationUtils $authenticationUtils){


        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername=$authenticationUtils->getLastUsername();

        if($error){
            $this->addFlash('login','Error Login');
        }

        if(TRUE === $this->get('security.authorization_checker')->isGranted('ROLE_USER')){
            return $this->redirectToRoute('security_home');
        }
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="security_logout")
     */
    public function logout(){
    }

    /**
     * @Route("/{id}/edit", name="security_profil", methods={"GET","POST"})
     */
    public function edit(Request $request, User $user,UserPasswordEncoderInterface $encoder): Response
    {
        $user->setPassword("");
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user,$user->getPassword());
            $user->setPassword($hash);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('security_home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }
}
