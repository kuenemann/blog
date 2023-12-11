<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccueilController extends AbstractController
{
    #[Route('/', name: 'app_accueil')]
    public function index(ArticleRepository $articleRepo): Response
    {
        // Vérifie si l'utilisateur est connecté et actif
        if ($this->getUser() && $this->getUser()->getIsActive()) {
            // Récupère les articles
            $articles = $articleRepo->findAll();

            return $this->render('accueil/index.html.twig', [
                'articles' => $articles
            ]);
        } else {
            // Redirige vers la page de connexion si l'utilisateur n'est pas actif
            return $this->redirectToRoute('app_login');
        }
    }
}
