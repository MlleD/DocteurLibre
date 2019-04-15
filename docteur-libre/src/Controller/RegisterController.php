<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
use App\Entity\Patient;
use App\Form\PatientType;
use App\Entity\Doctor;
use App\Form\DoctorType;

class RegisterController extends AbstractController {
    /**
     * @Route("/register/patient", name="register.patient")
     * @return Response
     */
    public function register_patient(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient, [
            'action' => $this->generateUrl('register.patient')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /* Hashage du mot de passe */
            //$password = $passwordEncoder->encodePassword($patient, $patient->getPassword());
            //$patient->setPassword($password);

            //var_dump($patient); die;// Debug de la variable avant l'envoi.
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
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
        $form = $this->createForm(DoctorType::class, $doctor, [
            'action' => $this->generateUrl('register.doctor')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($doctor);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('register.doctor.html.twig', [
            'register_form_doctor' => $form->createView()
        ]);
    }
}
