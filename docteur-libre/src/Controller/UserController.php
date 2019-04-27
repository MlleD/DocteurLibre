<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\User;
use App\Entity\Doctor;
use App\Entity\Patient;

class UserController extends AbstractController {
    /**
     * @Route("/profile/{id}", name="profile")
     * @return Response
     */
    public function show_profile($id) : Response {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($id);

        $doctor = $this->getDoctrine()
        ->getRepository(Doctor::class)
        ->findOneBy(array('user_id' => $id));

        if ($doctor != null) {
            return $this->render('profile.html.twig', [
                'user' => $user,
                'doctor' => $doctor,
                'is_patient' => False
            ]);
        }

        $patient = $this->getDoctrine()
        ->getRepository(Patient::class)
        ->findOneBy(array('user_id' => $id));

        return $this->render('profile.html.twig', [
            'user' => $user,
            'patient' => $patient,
            'is_patient' => True
        ]);
    }
}
