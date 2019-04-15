<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Doctor;
use App\Form\DoctorType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegisterDoctorController extends AbstractController {
    /**
     * @Route("/register_doctor", name="register_doctor")
     * @return Response
     */
    public function index(Request $request, UserPasswordEncoderInterface $passwordEncoder) : Response {
        $doctor = new Doctor();
        $form = $this->createForm(DoctorType::class, $doctor, [
            'action' => $this->generateUrl('register_doctor')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($doctor);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('register_doctor.html.twig', [
            'register_form_doctor' => $form->createView()
        ]);
    }
}
