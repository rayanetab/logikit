<?php

namespace App\EventSubscriber;

use App\Entity\History;
use App\Entity\Asset;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Workflow\Event\CompletedEvent;

class HistorySubscriber implements EventSubscriberInterface
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private Security $security
    ) {}

    public function onWorkflowCompleted(CompletedEvent $event): void
    {
        $asset = $event->getSubject();
        
        if (!$asset instanceof Asset) {
            return;
        }

        $user = $this->security->getUser();
        
        $history = new History();
        $history->setAsset($asset);
        $history->setUser($user);
        $history->setAction('Statut changé en : ' . $asset->getStatus());
        $history->setDate(new \DateTimeImmutable());

        $this->entityManager->persist($history);
        $this->entityManager->flush();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'workflow.completed' => 'onWorkflowCompleted',
        ];
    }
}