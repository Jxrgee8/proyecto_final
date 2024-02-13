<?php

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaRepository::class)]
class Lista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $tipo_lista = null;

    #[ORM\ManyToOne(inversedBy: 'listas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\ManyToMany(targetEntity: Serie::class, mappedBy: 'lista')]
    private Collection $serie;

    public function __construct()
    {
        $this->serie = new ArrayCollection();
    }

    /* // ?: Usar setId() para generar un ID formado por ID_LISTA+ID_USUARIO
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }
    */

    public function getId(): ?int
    {
        return $this->id;
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
            $serie->addListum($this);
        }

        return $this;
    }

    public function removeSerie(Serie $serie): static
    {
        if ($this->serie->removeElement($serie)) {
            $serie->removeListum($this);
        }

        return $this;
    }
}
