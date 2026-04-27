<?php

namespace App\Entity;

use App\Repository\AssignmentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AssignmentRepository::class)]
class Assignment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $assigned_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $returned_at = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pdf_filename = null;

    #[ORM\ManyToOne(inversedBy: 'assignments')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    private ?Asset $asset = null;

    #[ORM\ManyToOne(inversedBy: 'no')]
    private ?Consumable $consumable = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAssignedAt(): ?\DateTimeImmutable
    {
        return $this->assigned_at;
    }

    public function setAssignedAt(\DateTimeImmutable $assigned_at): static
    {
        $this->assigned_at = $assigned_at;

        return $this;
    }

    public function getReturnedAt(): ?\DateTimeImmutable
    {
        return $this->returned_at;
    }

    public function setReturnedAt(?\DateTimeImmutable $returned_at): static
    {
        $this->returned_at = $returned_at;

        return $this;
    }

    public function getPdfFilename(): ?string
    {
        return $this->pdf_filename;
    }

    public function setPdfFilename(?string $pdf_filename): static
    {
        $this->pdf_filename = $pdf_filename;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getAsset(): ?Asset
    {
        return $this->asset;
    }

    public function setAsset(?Asset $asset): static
    {
        $this->asset = $asset;

        return $this;
    }

    public function getConsumable(): ?Consumable
    {
        return $this->consumable;
    }

    public function setConsumable(?Consumable $consumable): static
    {
        $this->consumable = $consumable;

        return $this;
    }
}
