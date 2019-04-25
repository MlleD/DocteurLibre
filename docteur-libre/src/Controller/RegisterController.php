<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
use App\Entity\Patient;
use App\Entity\Doctor;
use App\Entity\User;
use App\Form\DoctorRegisterType;
use App\Form\PatientRegisterType;

class RegisterController extends AbstractController {
    /**
     * @Route("/register/patient", name="register.patient")
     * @return Response
     */
    public function register_patient(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $patient = new Patient();
        $form = $this->createForm(PatientRegisterType::class, $patient, [
            'action' => $this->generateUrl('register.patient')
        ]);

        $form->handleRequest($request);

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

            return $this->redirectToRoute('home');
        }

        return $this->render('register.patient.html.twig', [
            'register_form_patient' => $form->createView()
        ]);
    }

    /**
     * @Route("/register/doctor", name="register.doctor")
     * @return Response
     */
    public function register_doctor(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $doctor = new Doctor();
        $form = $this->createForm(DoctorRegisterType::class, $doctor, [
            'action' => $this->generateUrl('register.doctor')
        ]);

        $form->handleRequest($request);

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
            
            return $this->redirectToRoute('home');
        }

        return $this->render('register.doctor.html.twig', [
            'register_form_doctor' => $form->createView()
        ]);
    }
}
