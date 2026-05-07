<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\AssignmentRepository;
use App\Repository\HistoryRepository;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(AssignmentRepository $assignmentRepository, HistoryRepository $historyRepository): Response
    {
        $user = $this->getUser();
        
        $assignments = $assignmentRepository->findBy(
            ['user' => $user],
            ['assigned_at' => 'DESC']
        );

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'assignments' => $assignments,
        ]);
    }
}