<?php

namespace App\Controller;

use App\Repository\AssetRepository;
use App\Repository\ConsumableRepository;
use App\Repository\AssignmentRepository;
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
        AssignmentRepository $assignmentRepository
    ): Response
    {
        $totalAssets = count($assetRepository->findAll());
        $availableAssets = count($assetRepository->findBy(['status' => 'available']));
        $underRepair = count($assetRepository->findBy(['status' => 'maintenance']));
        $recentAssignments = $assignmentRepository->findBy([], ['assigned_at' => 'DESC'], 5);

        $stockAlerts = 0;
        foreach ($consumableRepository->findAll() as $consumable) {
            $threshold = $consumable->getStockAlertThreshold() ?? 5;
            if ($consumable->getStockQuantity() <= $threshold) {
                $stockAlerts++;
            }
        }

        // Statistiques annuelles - attributions par mois
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

        // Stats par statut
        $statusStats = [
            'available' => count($assetRepository->findBy(['status' => 'available'])),
            'assigned' => count($assetRepository->findBy(['status' => 'assigned'])),
            'maintenance' => count($assetRepository->findBy(['status' => 'maintenance'])),
            'lost' => count($assetRepository->findBy(['status' => 'lost'])),
            'retired' => count($assetRepository->findBy(['status' => 'retired'])),
        ];

        return $this->render('dashboard/index.html.twig', [
            'totalAssets' => $totalAssets,
            'availableAssets' => $availableAssets,
            'underRepair' => $underRepair,
            'stockAlerts' => $stockAlerts,
            'recentAssignments' => $recentAssignments,
            'monthlyStats' => array_values($monthlyStats),
            'statusStats' => $statusStats,
        ]);
    }
}