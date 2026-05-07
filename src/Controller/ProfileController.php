<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\AssignmentRepository;
use App\Repository\AssetRepository;

class ProfileController extends AbstractController
{
    #[Route('/profile', name: 'app_profile')]
    #[IsGranted('ROLE_USER')]
    public function index(AssignmentRepository $assignmentRepository, AssetRepository $assetRepository): Response
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
}