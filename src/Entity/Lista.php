<?php

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaRepository::class)]
class Lista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'Lista', targetEntity: Serie::class)]
    private Collection $series;

    #[ORM\Column(length: 60)]
    private ?string $tipo_lista = null;

    #[ORM\ManyToOne(inversedBy: 'listas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    /* //TODO: Usar setId() para generar un ID formado por ID_LISTA+ID_USUARIO
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }
    */

    public function getId(): ?int
    {
        return $this->id;
        return $this->series;
    }

    /**
    * @return Collection<int, Serie>
    */
    public function getSeries(): Collection
    {
    return $this->series;
    }

    public function addSeries(Serie $series): static
    {
    if (!$this->series->contains($series)) {
        $this->series->add($series);
        $series->setLista($this);
    }

    return $this;
    }

    public function removeSeries(Serie $series): static
    {
    if ($this->series->removeElement($series)) {
        // set the owning side to null (unless already changed)
        if ($series->getLista() === $this) {
            $series->setLista(null);
        }
    }

    return $this;
    }

    public function getTipoLista(): ?string
    {
        return $this->tipo_lista;
    }

    public function setTipoLista(string $tipo_lista): static
    {
        $this->tipo_lista = $tipo_lista;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }
}
