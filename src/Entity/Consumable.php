<?php

namespace App\Entity;

use App\Repository\ConsumableRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ConsumableRepository::class)]
class Consumable
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $stock_quantity = null;

    /**
     * @var Collection<int, Assignment>
     */
    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'consumable')]
    private Collection $no;

    #[ORM\Column(nullable: true)]
    private ?int $stock_alert_threshold = null;

    public function __construct()
    {
        $this->no = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stock_quantity;
    }

    public function setStockQuantity(int $stock_quantity): static
    {
        $this->stock_quantity = $stock_quantity;

        return $this;
    }

    /**
     * @return Collection<int, Assignment>
     */
    public function getNo(): Collection
    {
        return $this->no;
    }

    public function addNo(Assignment $no): static
    {
        if (!$this->no->contains($no)) {
            $this->no->add($no);
            $no->setConsumable($this);
        }

        return $this;
    }

    public function removeNo(Assignment $no): static
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getConsumable() === $this) {
                $no->setConsumable(null);
            }
        }

        return $this;
    }

    public function getStockAlertThreshold(): ?int
    {
        return $this->stock_alert_threshold;
    }

    public function setStockAlertThreshold(?int $stock_alert_threshold): static
    {
        $this->stock_alert_threshold = $stock_alert_threshold;

        return $this;
    }
}
