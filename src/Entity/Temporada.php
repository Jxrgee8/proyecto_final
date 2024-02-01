<?php

namespace App\Entity;

use App\Repository\TemporadaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemporadaRepository::class)]
class Temporada
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_temp = null;

    #[ORM\ManyToOne(inversedBy: 'temporadas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $Serie = null;

    #[ORM\OneToMany(mappedBy: 'Temporada', targetEntity: Capitulos::class)]
    private Collection $capitulos;

    public function __construct()
    {
        $this->capitulos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroTemp(): ?int
    {
        return $this->numero_temp;
    }

    public function setNumeroTemp(int $numero_temp): static
    {
        $this->numero_temp = $numero_temp;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->Serie;
    }

    public function setSerie(?Serie $Serie): static
    {
        $this->Serie = $Serie;

        return $this;
    }

    /**
     * @return Collection<int, Capitulos>
     */
    public function getCapitulos(): Collection
    {
        return $this->capitulos;
    }

    public function addCapitulo(Capitulos $capitulo): static
    {
        if (!$this->capitulos->contains($capitulo)) {
            $this->capitulos->add($capitulo);
            $capitulo->setTemporada($this);
        }

        return $this;
    }

    public function removeCapitulo(Capitulos $capitulo): static
    {
        if ($this->capitulos->removeElement($capitulo)) {
            // set the owning side to null (unless already changed)
            if ($capitulo->getTemporada() === $this) {
                $capitulo->setTemporada(null);
            }
        }

        return $this;
    }
}
