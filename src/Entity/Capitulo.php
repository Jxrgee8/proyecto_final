<?php

namespace App\Entity;

use App\Repository\CapituloRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapituloRepository::class)]
class Capitulo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_cap = null;

    #[ORM\ManyToOne(inversedBy: 'capitulos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Temporada $Temporada = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCap(): ?int
    {
        return $this->numero_cap;
    }

    public function setNumeroCap(int $numero_cap): static
    {
        $this->numero_cap = $numero_cap;

        return $this;
    }

    public function getTemporada(): ?Temporada
    {
        return $this->Temporada;
    }

    public function setTemporada(?Temporada $Temporada): static
    {
        $this->Temporada = $Temporada;

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
}
