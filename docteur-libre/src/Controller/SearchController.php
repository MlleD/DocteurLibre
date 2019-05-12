<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\SearchDoctorType;
use App\Entity\Doctor;
use App\Entity\User;

class SearchController extends AbstractController {
    /**
     * @Route("/search", name="search")
     * @return Response
     */
    public function search(Request $request) : Response {
        // Crée le formulaire
        $form = $this->createForm(SearchDoctorType::class, null, [
            'action' => $this->generateUrl('search')
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $orm = $this->getDoctrine();

            $profession = $form->get('profession')->getData();

            // Construction de l'expression de requête permettant
            // de récupérer l'id, le nom, le prénom et la profession
            // des docteurs dont le nom de la profession contient 
            // ce qui est écrit dans le champ "profession"
            $expr = "SELECT u.id, u.first_name, u.last_name, d.profession
            FROM " . User::class . " u, " . Doctor::class . " d
            WHERE d.user_id = u.id AND d.profession LIKE '%" . $profession . "%'";
            
            // Création de la requête
            $query = $orm->getManager()->createQuery($expr);

            // Affichage du template de résultats de recherche
            return $this->render('search.results.html.twig', [
                'search_results' => $query->getResult(),
                'search' => $profession
            ]);
        }

        // Affichage du formulaire d'inscription patient si le formulaire n'a pas été soumis.
        return $this->render('search.html.twig', [
            'search_form' => $form->createView()
        ]);
    }
}