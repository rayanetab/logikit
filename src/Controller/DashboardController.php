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

        return $this->render('dashboard/index.html.twig', [
            'totalAssets' => $totalAssets,
            'availableAssets' => $availableAssets,
            'underRepair' => $underRepair,
            'stockAlerts' => $stockAlerts,
            'recentAssignments' => $recentAssignments,
        ]);
    }
}