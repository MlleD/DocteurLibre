<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
use App\Entity\User;
use App\Form\DoctorRegisterType;
use App\Form\PatientRegisterType;

class RegisterController extends AbstractController {
    /**
     * @Route("/register/patient", name="register.patient")
     * @return Response
     */
    public function register_patient(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        // Si l'utilisateur est connecté ...
        if ($this->getUser() != null)
           return $this->redirectToRoute('404');

        // Crée le formulaire d'inscription patient.
        $form = $this->createForm(PatientRegisterType::class, null, [
            'action' => $this->generateUrl('register.patient')
        ]);

        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et s'il est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $user = $form->get('user')->getData();
            $password = $passwordEncoder->encodePassword(
                $user,
                $form->get('user')->get('password')->getData()
            );
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();

            $userid = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
            $pat = $form->get('patient')->getData();
            $pat->setUserid($userid);
            $em->persist($pat);
            $em->flush();

            return $this->redirectToRoute('home'); // Redirige vers la page d'accueil.
        }

        // Affichage du formulaire d'inscription patient si le formulaire n'a pas été soumis.
        return $this->render('register.patient.html.twig', [
            'register_form_patient' => $form->createView()
        ]);
    }

    /**
     * @Route("/register/doctor", name="register.doctor")
     * @return Response
     */
    public function register_doctor(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        // Si l'utilisateur est connecté ...
        if ($this->getUser() != null)
           return $this->redirectToRoute('404');
        
        // Crée le formulaire d'inscription médecin.
        $form = $this->createForm(DoctorRegisterType::class, null, [
            'action' => $this->generateUrl('register.doctor')
        ]);

        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis et s'il est valide.
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            
            $user = $form->get('user')->getData();
            $password = $passwordEncoder->encodePassword(
                $user,
                $form->get('user')->get('password')->getData()
            );
            $user->setPassword($password);
            $em->persist($user);
            $em->flush();

            $userid = $this->getDoctrine()->getRepository(User::class)->find($user->getId());
            $doc = $form->get('doctor')->getData();
            $doc->setUserid($userid);
            $em->persist($doc);
            $em->flush();
            
            return $this->redirectToRoute('home'); // Redirige vers la page d'accueil.
        }
        
        // Affichage du formulaire d'inscription patient si le formulaire n'a pas été soumis.
        return $this->render('register.doctor.html.twig', [
            'register_form_doctor' => $form->createView()
        ]);
    }
}
