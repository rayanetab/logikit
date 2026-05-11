<?php

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\ConsumableRepository;
use App\Repository\AssignmentRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DashboardController extends AbstractController
{
    #[Route('/dashboard', name: 'dashboard')]
    #[IsGranted('ROLE_USER')]
    public function index(
        AssetRepository $assetRepository,
        ConsumableRepository $consumableRepository,
        AssignmentRepository $assignmentRepository,
        UserRepository $userRepository
    ): Response
    {
        $user = $this->getUser();
        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isManager = $this->isGranted('ROLE_MANAGER');

        $totalAssets = count($assetRepository->findAll());
        $availableAssets = count($assetRepository->findBy(['status' => 'available']));
        $underRepair = count($assetRepository->findBy(['status' => 'maintenance']));

        $stockAlerts = 0;
        foreach ($consumableRepository->findAll() as $consumable) {
            $threshold = $consumable->getStockAlertThreshold() ?? 5;
            if ($consumable->getStockQuantity() <= $threshold) {
                $stockAlerts++;
            }
        }

        if ($isAdmin) {
            $recentAssignments = $assignmentRepository->findBy([], ['assigned_at' => 'DESC'], 5);
        } else {
            $recentAssignments = $assignmentRepository->findBy(
                ['user' => $user],
                ['assigned_at' => 'DESC'],
                5
            );
        }

        $allAssignments = $assignmentRepository->findAll();
        $monthlyStats = array_fill(1, 12, 0);
        foreach ($allAssignments as $assignment) {
            if ($assignment->getAssignedAt()) {
                $month = (int) $assignment->getAssignedAt()->format('m');
                $year = (int) $assignment->getAssignedAt()->format('Y');
                if ($year == date('Y')) {
                    $monthlyStats[$month]++;
                }
            }
        }

        $allAssets = $assetRepository->findAll();
        $monthlyAssets = array_fill(1, 12, 0);
        foreach ($allAssets as $asset) {
            if ($asset->getCreatedAt()) {
                $month = (int) $asset->getCreatedAt()->format('m');
                $year = (int) $asset->getCreatedAt()->format('Y');
                if ($year == date('Y')) {
                    $monthlyAssets[$month]++;
                }
            }
        }

        $statusStats = [
            'available' => count($assetRepository->findBy(['status' => 'available'])),
            'assigned' => count($assetRepository->findBy(['status' => 'assigned'])),
            'maintenance' => count($assetRepository->findBy(['status' => 'maintenance'])),
            'lost' => count($assetRepository->findBy(['status' => 'lost'])),
            'retired' => count($assetRepository->findBy(['status' => 'retired'])),
        ];

        // Stats par catégorie
$categoryStats = [
    'PC' => count($assetRepository->findBy(['Category' => 'PC'])),
    'Accessoire' => count($assetRepository->findBy(['Category' => 'Accessoire'])),
    'Ecran' => count($assetRepository->findBy(['Category' => 'Ecran'])),
    'Telephone' => count($assetRepository->findBy(['Category' => 'Telephone'])),
    'Autre' => count($assetRepository->findBy(['Category' => 'Autre'])),
];

        return $this->render('dashboard/index.html.twig', [
            'totalAssets' => $totalAssets,
            'availableAssets' => $availableAssets,
            'underRepair' => $underRepair,
            'stockAlerts' => $stockAlerts,
            'recentAssignments' => $recentAssignments,
            'monthlyStats' => array_values($monthlyStats),
            'monthlyAssets' => array_values($monthlyAssets),
            'statusStats' => $statusStats,
            'isAdmin' => $isAdmin,
            'isManager' => $isManager,
            'categoryStats' => $categoryStats,
        ]);
    }
}