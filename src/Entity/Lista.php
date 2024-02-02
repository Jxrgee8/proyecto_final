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
}
