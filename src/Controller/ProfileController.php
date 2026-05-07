<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\AssignmentRepository;
use App\Repository\AssetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(AssignmentRepository $assignmentRepository): Response
    {
        $user = $this->getUser();
        
        $assignments = $assignmentRepository->findBy(
            ['user' => $user],
            ['assigned_at' => 'DESC']
        );

        $totalAssignments = count($assignments);
        $activeAssignments = count(array_filter($assignments, fn($a) => $a->getReturnedAt() === null));
        $returnedAssignments = $totalAssignments - $activeAssignments;

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'assignments' => $assignments,
            'totalAssignments' => $totalAssignments,
            'activeAssignments' => $activeAssignments,
            'returnedAssignments' => $returnedAssignments,
        ]);
    }

    #[Route('/profile/password', name: 'app_profile_password', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
    public function changePassword(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        $user = $this->getUser();
        $newPassword = $request->request->get('new_password');
        $confirmPassword = $request->request->get('confirm_password');

        if ($newPassword !== $confirmPassword) {
            $this->addFlash('error', 'Les mots de passe ne correspondent pas !');
            return $this->redirectToRoute('app_profile');
        }

        if (strlen($newPassword) < 6) {
            $this->addFlash('error', 'Le mot de passe doit contenir au moins 6 caractères !');
            return $this->redirectToRoute('app_profile');
        }

        $user->setPassword($hasher->hashPassword($user, $newPassword));
        $em->flush();

        $this->addFlash('success', 'Mot de passe modifié avec succès !');
        return $this->redirectToRoute('app_profile');
    }
}