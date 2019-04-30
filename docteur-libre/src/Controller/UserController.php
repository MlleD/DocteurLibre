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
        // Crée le formulaire de modification de compte patient.
        $form = $this->createForm(PatientRegisterType::class, null, [
            'action' => $this->generateUrl('register.patient')
        ]);

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

            return $this->redirectToRoute('home');
        }

        // Affichage du formulaire de modification de profil patient si le formulaire n'a pas été soumis.
        return $this->render('register.patient.html.twig', [
            'register_form_patient' => $form->createView()
        ]);
    }
}
