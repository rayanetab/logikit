<?php

namespace App\Twig;

use App\Repository\ConsumableRepository;
use App\Repository\AssetRepository;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class GlobalVariablesExtension extends AbstractExtension implements GlobalsInterface
{
    public function __construct(
        private ConsumableRepository $consumableRepository,
        private AssetRepository $assetRepository,
    ) {}

    public function getGlobals(): array
    {
        $stockAlerts = 0;
        foreach ($this->consumableRepository->findAll() as $consumable) {
            $threshold = $consumable->getStockAlertThreshold() ?? 5;
            if ($consumable->getStockQuantity() <= $threshold) {
                $stockAlerts++;
            }
        }

        $maintenanceCount = count($this->assetRepository->findBy(['status' => 'maintenance']));

        return [
            'globalStockAlerts' => $stockAlerts,
            'globalMaintenanceCount' => $maintenanceCount,
        ];
    }
}