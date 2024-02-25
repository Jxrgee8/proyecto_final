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

    #[ORM\ManyToOne(inversedBy: 'temporada')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $Serie = null;

    #[ORM\OneToMany(mappedBy: 'Temporada', targetEntity: Capitulo::class)]
    private Collection $capitulo;

    public function __construct()
    {
        $this->capitulo = new ArrayCollection();
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
    public function getCapitulo(): Collection
    {
        return $this->capitulo;
    }

    public function addCapitulo(Capitulo $capitulo): static
    {
        if (!$this->capitulo->contains($capitulo)) {
            $this->capitulo->add($capitulo);
            $capitulo->setTemporada($this);
        }

        return $this;
    }

    public function removeCapitulo(Capitulo $capitulo): static
    {
        if ($this->capitulo->removeElement($capitulo)) {
            // set the owning side to null (unless already changed)
            if ($capitulo->getTemporada() === $this) {
                $capitulo->setTemporada(null);
            }
        }

        return $this;
    }

    public function getTemporadaSerie() {
        return $this->getSerie()." - Temporada ".$this->getNumeroTemp();
    }

    public function __toString(): string
    {
        return $this->getTemporadaSerie();
    }
}
