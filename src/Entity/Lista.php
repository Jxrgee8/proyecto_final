<?php

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\OneToMany(mappedBy: 'lista', targetEntity: SerieLista::class)]
    private Collection $serieLista;

    public function __construct()
    {
        $this->serieLista = new ArrayCollection();
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

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    /**
     * @return Collection<int, SerieLista>
     */
    public function getSerieListas(): Collection
    {
        return $this->serieLista;
    }

    public function addSerieLista(SerieLista $serieLista): static
    {
        if (!$this->serieLista->contains($serieLista)) {
            $this->serieLista->add($serieLista);
            $serieLista->setLista($this);
        }

        return $this;
    }

    public function removeSerieLista(SerieLista $serieLista): static
    {
        if ($this->serieLista->removeElement($serieLista)) {
            // set the owning side to null (unless already changed)
            if ($serieLista->getLista() === $this) {
                $serieLista->setLista(null);
            }
        }

        return $this;
    }
}
