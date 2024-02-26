<?php

namespace App\Entity;

use App\Repository\StreamingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StreamingRepository::class)]
class Streaming
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\ManyToMany(targetEntity: Serie::class, inversedBy: 'streamings')]
    private Collection $serie;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $icono_src = null;

    public function __construct()
    {
        $this->serie = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSerie(): Collection
    {
        return $this->serie;
    }

    public function addSerie(Serie $serie): static
    {
        if (!$this->serie->contains($serie)) {
            $this->serie->add($serie);
        }

        return $this;
    }

    public function removeSerie(Serie $serie): static
    {
        $this->serie->removeElement($serie);

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }

    public function getIconoSrc(): ?string
    {
        return $this->icono_src;
    }

    public function setIconoSrc(?string $icono_src): static
    {
        $this->icono_src = $icono_src;

        return $this;
    }
}
