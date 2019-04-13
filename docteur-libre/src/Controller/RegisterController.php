<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\Patient;
use App\Form\PatientType;

class RegisterController extends AbstractController {
    /**
     * @Route("/register", name="register")
     * @return Response
     */
    public function index(Request $request) : Response {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient, [
            'action' => $this->generateUrl('register')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted()) { // && $form->isValid()
            //var_dump($patient); die;// Debug de la variable avant l'envoi.
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();

        }

        //$properties = $this->repository->findAll();
        return $this->render('register.html.twig', [
            'register_form' => $form->createView()
        ]);
    }

}
