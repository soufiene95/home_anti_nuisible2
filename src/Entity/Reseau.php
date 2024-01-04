<?php

namespace App\Entity;

use App\Repository\ReseauRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReseauRepository::class)]
class Reseau
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reseauSociaux = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReseauSociaux(): ?string
    {
        return $this->reseauSociaux;
    }

    public function setReseauSociaux(string $reseauSociaux): static
    {
        $this->reseauSociaux = $reseauSociaux;

        return $this;
    }
}
