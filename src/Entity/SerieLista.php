<?php

namespace App\Entity;

use App\Repository\SerieListaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieListaRepository::class)]
class SerieLista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'serieLista')]
    private ?Serie $serie = null;

    #[ORM\ManyToOne(inversedBy: 'serieListas')]
    private ?Lista $lista = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_agregado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getLista(): ?Lista
    {
        return $this->lista;
    }

    public function setLista(?Lista $lista): static
    {
        $this->lista = $lista;

        return $this;
    }

    public function getFechaAgregado(): ?\DateTimeInterface
    {
        return $this->fecha_agregado;
    }

    public function setFechaAgregado(\DateTimeInterface $fecha_agregado): static
    {
        $this->fecha_agregado = $fecha_agregado;

        return $this;
    }
}
