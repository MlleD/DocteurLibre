<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Twig\Environment;
use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Patient;
use App\Form\AppointmentType;
use App\Form\DoctorRegisterType;
use App\Form\PatientRegisterType;


class UserController extends AbstractController {
    /**
     * @Route("/profile/{id}", name="profile")
     * @return Response
     */
    public function show_profile($id) : Response {

        // Cherche l'utilisateur par son ID.
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($id);

        // Vérifie si l'utilisateur est présent dans la table médecin
        $doctor = $this->getDoctrine()
        ->getRepository(Doctor::class)
        ->findOneBy(array('user_id' => $id));

        // Si l'utilisateur est médecin ...
        if ($doctor != null) {
            return $this->render('profile.html.twig', [
                'user' => $user,
                'doctor' => $doctor,
                'is_patient' => False
            ]);
        }

        // Vérifie si l'utilisateur est présent dans la table patient.
        $patient = $this->getDoctrine()
        ->getRepository(Patient::class)
        ->findOneBy(array('user_id' => $id));

        return $this->render('profile.html.twig', [
            'user' => $user,
            'patient' => $patient,
            'is_patient' => True
        ]);
    }

    /**
     * @Route("/profile/{id}/edit", name="edit.profile")
     * @return Response
     */
    public function edit_profile($id, Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $orm = $this->getDoctrine();
        // Crée le formulaire de modification de compte
        $user = $orm->getRepository(User::class)->find($id);
        $specs = $orm->getRepository(Patient::class)->findOneBy(['user_id' => $user->getId()]);
        $ispatient = $specs != null;
        $form = null;
        $specName = null;
        if ($ispatient) {
            $specName = 'patient';
            $form = $this->createForm(PatientRegisterType::class, ['user' =>$user, 'patient' =>$specs]);
        }
        else {
            $specName = 'doctor';
            $specs = $orm->getRepository(Doctor::class)->findOneBy(['user_id' => $user->getId()]);
            $form = $this->createForm(DoctorRegisterType::class, ['user' =>$user, 'doctor' => $specs]);
        }

        $form->handleRequest($request);

         // Vérifie si le formulaire a été soumis et s'il est valide.
         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();

            return $this->redirectToRoute('home');
        }

        // Affichage du formulaire de modification de profil si le formulaire n'a pas été soumis.
        return $this->render('edit-profile.html.twig', [
            'register_form_' . $specName => $form->createView(),
            'template_base' => 'infos.' . $specName . '.html.twig'
        ]);
    }

    /**
     * @Route("/profile/{doctor_id}/new_appointment", name="profile.new.appointment")
     * @return Response
     */
    public function new_appointment($doctor_id) : Response {
        // Vérifie si l'utilisateur est présent dans la table médecin
        $doctor = $this->getDoctrine()
        ->getRepository(Doctor::class)
        ->findOneBy(array('user_id' => $doctor_id));

        // Si l'utilisateur n'est pas connecté ...
        if ($this->getUser() == null)
           return $this->redirectToRoute('404');

        // Récupère l'ID de l'utilisateur connecté.
        $patient_id = $this->getUser()->getId();

        // Vérifie si l'utilisateur connecté est présent dans la table patient.
        $patient = $this->getDoctrine()
        ->getRepository(Patient::class)
        ->findOneBy(array('user_id' => $patient_id));

        /* Si l'utilisateur avec lequel le patient veut prendre rendez-vous n'est pas médecin, 
           ou si l'utilisateur connecté n'est pas un patient ... */
        if ($doctor == null or $patient == null)
           return $this->redirectToRoute('404');

        // Crée le formulaire de prise de rendez-vous.
        $form = $this->createForm(AppointmentType::class, null, [
            'action' => $this->generateUrl('profile.new.appointment', ['doctor_id' => $doctor_id])
        ]); 

        // Debug
        dump($patient_id);
        dump((int) $doctor_id);

        // Vérifie si le formulaire a été soumis et s'il est valide.
         if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $appointment = $form->get('appointment')->getData();
            $appointment->setPatient($patient_id);
            $appointment->setDoctor((int)$doctor_id);
                      
            $em->persist($appointment);
            $em->flush();
            
            return $this->redirectToRoute('home');
        }

        // Affichage du formulaire de prise de rendez-vous si le formulaire n'a pas été soumis.
        return $this->render('profile.new.appointment.html.twig', [
            'appointment_form' => $form->createView()
        ]);
    }
}
