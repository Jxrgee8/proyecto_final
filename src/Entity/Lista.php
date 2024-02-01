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

    #[ORM\ManyToMany(targetEntity: Serie::class, inversedBy: 'listas')]
    private Collection $series_viendo;

    #[ORM\ManyToMany(targetEntity: Serie::class, inversedBy: 'listas')]
    private Collection $series_por_ver;

    #[ORM\ManyToMany(targetEntity: Serie::class, inversedBy: 'listas')]
    private Collection $series_vistas;

    public function __construct()
    {
        $this->series_viendo = new ArrayCollection();
        $this->series_por_ver = new ArrayCollection();
        $this->series_vistas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeriesViendo(): Collection
    {
        return $this->series_viendo;
    }

    public function addSeriesViendo(Serie $seriesViendo): static
    {
        if (!$this->series_viendo->contains($seriesViendo)) {
            $this->series_viendo->add($seriesViendo);
        }

        return $this;
    }

    public function removeSeriesViendo(Serie $seriesViendo): static
    {
        $this->series_viendo->removeElement($seriesViendo);

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeriesPorVer(): Collection
    {
        return $this->series_por_ver;
    }

    public function addSeriesPorVer(Serie $seriesPorVer): static
    {
        if (!$this->series_por_ver->contains($seriesPorVer)) {
            $this->series_por_ver->add($seriesPorVer);
        }

        return $this;
    }

    public function removeSeriesPorVer(Serie $seriesPorVer): static
    {
        $this->series_por_ver->removeElement($seriesPorVer);

        return $this;
    }

    /**
     * @return Collection<int, Serie>
     */
    public function getSeriesVistas(): Collection
    {
        return $this->series_vistas;
    }

    public function addSeriesVista(Serie $seriesVista): static
    {
        if (!$this->series_vistas->contains($seriesVista)) {
            $this->series_vistas->add($seriesVista);
        }

        return $this;
    }

    public function removeSeriesVista(Serie $seriesVista): static
    {
        $this->series_vistas->removeElement($seriesVista);

        return $this;
    }
}
