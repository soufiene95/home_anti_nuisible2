<?php

namespace App\Entity;

use App\Repository\PrestationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
// use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PrestationsRepository::class)]
class Prestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $prestation = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    // #[Assert\File(
    //     maxSize: '2048k',
    //     extensions: ['pdf','jpg','jpeg','png','svg','webp'],
    //     extensionsMessage: 'votre image est invalide.',
    // )]
    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $montant = null;

    #[ORM\OneToMany(mappedBy: 'prestations', targetEntity: FacturesDetails::class)]
    private Collection $facturesDetails;

    public function __construct()
    {
        $this->facturesDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrestation(): ?string
    {
        return $this->prestation;
    }

    public function setPrestation(string $prestation): static
    {
        $this->prestation = $prestation;

        return $this;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): static
    {
        $this->image = $image;

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

    /**
     * @return Collection<int, FacturesDetails>
     */
    public function getFacturesDetails(): Collection
    {
        return $this->facturesDetails;
    }

    public function addFacturesDetail(FacturesDetails $facturesDetail): static
    {
        if (!$this->facturesDetails->contains($facturesDetail)) {
            $this->facturesDetails->add($facturesDetail);
            $facturesDetail->setPrestations($this);
        }

        return $this;
    }

    public function removeFacturesDetail(FacturesDetails $facturesDetail): static
    {
        if ($this->facturesDetails->removeElement($facturesDetail)) {
            // set the owning side to null (unless already changed)
            if ($facturesDetail->getPrestations() === $this) {
                $facturesDetail->setPrestations(null);
            }
        }

        return $this;
    }
}
