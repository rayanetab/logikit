<?php

namespace App\Entity;

use App\Repository\AssetRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
        #[ORM\Entity(repositoryClass: AssetRepository::class)]
        #[ORM\HasLifecycleCallbacks]
    class Asset
    {
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $serial_number = null;

    #[ORM\Column(length: 255)]
    private ?string $brand = null;

    #[ORM\Column(length: 255)]
    private ?string $model = null;

    #[ORM\Column(length: 50)]
    private ?string $status = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, Assignment>
     */
    #[ORM\OneToMany(targetEntity: Assignment::class, mappedBy: 'asset')]
    private Collection $no;

    /**
     * @var Collection<int, History>
     */
    #[ORM\OneToMany(targetEntity: History::class, mappedBy: 'asset')]
    private Collection $histories;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $Category = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $barcode = null;

    public function __construct()
    {
        $this->no = new ArrayCollection();
        $this->histories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerialNumber(): ?string
    {
        return $this->serial_number;
    }



    public function setSerialNumber(string $serial_number): static
    {
    $this->serial_number = $serial_number;
    return $this;
    }

  #[ORM\PrePersist]
  #[ORM\PreUpdate]
    public function generateBarcode(): void
    {
       if ($this->barcode === null) {
        $this->barcode = strtoupper(substr($this->category ?? 'AST', 0, 3)) . '-' . date('Y') . '-' . rand(1000, 9999);
    }
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getModel(): ?string
    {
        return $this->model;
    }

    public function setModel(string $model): static
    {
        $this->model = $model;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

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
            $no->setAsset($this);
        }

        return $this;
    }

    public function removeNo(Assignment $no): static
    {
        if ($this->no->removeElement($no)) {
            // set the owning side to null (unless already changed)
            if ($no->getAsset() === $this) {
                $no->setAsset(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, History>
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(History $history): static
    {
        if (!$this->histories->contains($history)) {
            $this->histories->add($history);
            $history->setAsset($this);
        }

        return $this;
    }

    public function removeHistory(History $history): static
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getAsset() === $this) {
                $history->setAsset(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?string
    {
        return $this->Category;
    }

    public function setCategory(?string $Category): static
    {
        $this->Category = $Category;

        return $this;
    }

    public function getBarcode(): ?string
    {
        return $this->barcode;
    }

    public function setBarcode(?string $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }
}
