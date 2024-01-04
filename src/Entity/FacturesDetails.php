<?php

namespace App\Entity;

use App\Repository\FacturesDetailsRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FacturesDetailsRepository::class)]
class FacturesDetails
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $quantite = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\ManyToOne(inversedBy: 'details')]
    private ?Factures $factures = null;

    #[ORM\ManyToOne(inversedBy: 'facturesDetails')]
    private ?Prestations $prestations = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): static
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): static
    {
        $this->montant = $montant;

        return $this;
    }

    public function getFactures(): ?Factures
    {
        return $this->factures;
    }

    public function setFactures(?Factures $factures): static
    {
        $this->factures = $factures;

        return $this;
    }

    public function getPrestations(): ?Prestations
    {
        return $this->prestations;
    }

    public function setPrestations(?Prestations $prestations): static
    {
        $this->prestations = $prestations;

        return $this;
    }
}
