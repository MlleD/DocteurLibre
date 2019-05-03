<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class ErrorController extends AbstractController {

    /**
     * @Route("/404", name="404")
     * @return Response
     */
    public function home() : Response {
      return $this->render('bundles/TwigBundle/Exception/error404.html.twig');
    }
}
