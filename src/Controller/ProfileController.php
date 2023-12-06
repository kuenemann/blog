<?php

namespace App\Controller;

use App\Form\ProfileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    public function index(): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        return $this->render('profile/show.html.twig', [
            'user' => $user,
            
        ]);
    }

    #[Route('/profile/edit-username', name: 'app_profile_edit_username')]
    public function editUsername(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        if ($request->isMethod('POST')) {
            $newUsername = $request->request->get('username');

            // Validez et mettez à jour le nom d'utilisateur

            $this->addFlash('success', 'Nom d\'utilisateur mis à jour avec succès!');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit_username.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit-bio', name: 'app_profile_edit_bio')]
    public function editBio(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        if ($request->isMethod('POST')) {
            $newBio = $request->request->get('bio');

            // Validez et mettez à jour la bio
            // ...

            $this->addFlash('success', 'Bio mise à jour avec succès!');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit_bio.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/profile/edit-profile', name: 'app_profile_edit_profile')]
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
            
        }

        $form = $this->createForm(ProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès!');
            return $this->redirectToRoute('app_profile');
        }

        return $this->render('profile/edit_profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user, 
        ]);
    }
}


    
    