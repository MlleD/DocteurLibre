<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController {
    /**
     * @Route("/login", name="login")
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $lastEmail = $authenticationUtils->getLastUsername(); // Récupère la dernière adresse e-mail saisie par l'utilisateur.
        $error = $authenticationUtils->getLastAuthenticationError(); // Récupère la dernière erreur d'authentification.
        return $this->render('login.html.twig', [
            'last_email' => $lastEmail,
            'error' => $error
        ]);
    }
}
