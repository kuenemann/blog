<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/user/{id}/edit', name: 'user_edit')]
    public function edit(Request $request, User $user): Response
    {   
       
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            if ($user->getGdpr() === null) {
                $user->setGdpr(new \DateTime());
            }
    
            $this->entityManager->flush();
    
            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }
    
        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/user/{id}/editer', name: 'user_editer')]
    public function editer(Request $request, User $utilisateur): Response
    {
        // Vérifier si l'utilisateur actuel est un administrateur
        if (!$this->isGranted('ROLE_ADMIN')) {
            throw new AccessDeniedException('Vous n\'avez pas les autorisations nécessaires pour bloquer/débloquer un compte.');
        }
    
        $formulaire = $this->createForm(UserType::class, $utilisateur);
        $formulaire->handleRequest($request);
    
        if ($formulaire->isSubmitted() && $formulaire->isValid()) {
            // Mettre à jour le statut isBlocked de l'utilisateur en fonction de la soumission du formulaire
            $isBlocked = $formulaire->get('isBlocked')->getData();
            $utilisateur->setIsBlocked($isBlocked);
    
            // Mettre à jour les rôles de l'utilisateur en fonction du statut isBlocked
            if ($utilisateur->getIsBlocked()) {
                // Code pour bloquer le compte
                $utilisateur->setRoles(['ROLE_BLOCKED']);
            } else {
                // Code pour débloquer le compte
                // Par exemple, réinitialisez les rôles à ceux d'un utilisateur normal
                $utilisateur->setRoles(['ROLE_USER']);
            }
    
            $this->entityManager->flush();
    
            return $this->redirectToRoute('app_profile', ['id' => $utilisateur->getId()]);
        }
    
        return $this->render('utilisateur/editer.html.twig', [
            'utilisateur' => $utilisateur,
            'formulaire' => $formulaire->createView(),
        ]);
    }

}




