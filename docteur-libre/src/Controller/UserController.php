<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;
use App\Entity\User;

class UserController extends AbstractController {
    /**
     * @Route("/profile/{id}", name="profile")
     * @return Response
     */
    public function show_profile($id) : Response {
        $user = $this->getDoctrine()
        ->getRepository(User::class)
        ->findOneById($id);

        //dump($user);

        return $this->render('profile.html.twig', [
            'user' => $user
        ]);
    }
}
