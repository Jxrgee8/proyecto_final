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

    //? null = "episodio + 1"
    //? false = "episodio + 1" && "temporada + 1"
    //? true = "delete->series_viendo($serie)" && "add->series_vistas($serie)"
    #[ORM\Column(nullable: true)]
    private ?bool $es_ultimo = null;

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

    public function isEsUltimo(): ?bool
    {
        return $this->es_ultimo;
    }

    public function setEsUltimo(?bool $es_ultimo): static
    {
        $this->es_ultimo = $es_ultimo;

        return $this;
    }
}
