<?php

namespace App\Service;

use App\Entity\Assignment;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class MailerService
{
    public function __construct(
        private MailerInterface $mailer,
        private string $fromEmail = 'noreply@logikit.fr'
    ) {}

    public function sendAssignmentEmail(Assignment $assignment): void
    {
        if (!$assignment->getUser() || !$assignment->getUser()->getEmail()) {
            return;
        }

        $user = $assignment->getUser();
        $asset = $assignment->getAsset();
        $consumable = $assignment->getConsumable();

        $materiel = $asset ? $asset->getBrand() . ' ' . $asset->getModel() : ($consumable ? $consumable->getName() : 'Matériel');
        $serie = $asset ? $asset->getSerialNumber() : '-';

        $email = (new Email())
            ->from($this->fromEmail)
            ->to($user->getEmail())
            ->subject('LogiKit - Nouveau matériel attribué')
            ->html("
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto;'>
                    <div style='background: #111827; color: white; padding: 20px; border-radius: 8px 8px 0 0;'>
                        <h1 style='margin: 0;'>LogiKit</h1>
                        <p style='margin: 5px 0 0; color: #9ca3af;'>Asset Management</p>
                    </div>
                    <div style='background: #f9fafb; padding: 30px; border-radius: 0 0 8px 8px;'>
                        <h2>Bonjour {$user->getPrenom()} {$user->getNom()},</h2>
                        <p>Un nouveau matériel vous a été attribué :</p>
                        <div style='background: white; padding: 20px; border-radius: 8px; border: 1px solid #e5e7eb;'>
                            <p><strong>Matériel :</strong> {$materiel}</p>
                            <p><strong>Numéro de série :</strong> {$serie}</p>
                            <p><strong>Date d'attribution :</strong> " . date('d/m/Y') . "</p>
                        </div>
                        <p style='color: #6b7280; font-size: 14px; margin-top: 20px;'>
                            Merci de prendre soin de ce matériel. En cas de problème, contactez votre Admin IT.
                        </p>
                        <p style='color: #6b7280; font-size: 12px;'>LogiKit © Aggrego-Tech 2026</p>
                    </div>
                </div>
            ");

        $this->mailer->send($email);
    }
}