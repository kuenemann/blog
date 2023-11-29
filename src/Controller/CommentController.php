<?php

namespace App\Controller;

use App\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Security;

class CommentController extends AbstractController
{
    private Security $security;
    private EntityManagerInterface $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    #[Route('/create-comment', name: 'create_comment', methods: ['POST'])]
    public function createComment(Request $request): Response
    {
        // Vérifiez si l'utilisateur est connecté
        if ($this->security->isGranted('IS_AUTHENTICATED_FULLY')) {
            // L'utilisateur est connecté, autorisez la création du commentaire

            // Exemple de création d'un nouveau commentaire
            $newComment = new Comment();
            $newComment->setContent('Nouveau commentaire');
            // Vous pouvez ajouter d'autres propriétés du commentaire ici

            // Définissez la date de création
            $newComment->setCreatedAt(new \DateTimeImmutable());

            // Récupérez l'utilisateur actuel et associez-le au commentaire
            $user = $this->getUser();
            $newComment->setUser($user);

            // Enregistrez le commentaire dans la base de données
            $this->entityManager->persist($newComment);
            $this->entityManager->flush();

            // Ajoutez une déclaration dump ici pour voir si elle est atteinte
            dump('Commentaire créé et persisté avec succès!');

            // Redirigez l'utilisateur vers la page des commentaires
            return $this->redirectToRoute('app_comment');
        } else {
            // L'utilisateur n'est pas connecté, redirigez-le vers la page de connexion
            // Vous pouvez personnaliser la route de redirection en fonction de vos besoins
            return $this->redirectToRoute('app_login');
        }
    }

    #[Route('/comment-page', name: 'app_comment', methods: ['GET'])]
    public function commentPage(): Response
    {
        // Votre logique pour afficher la page de commentaires ici
        // ...

        return $this->render('comment/comment_page.html.twig');
    }
}
