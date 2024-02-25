<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SerieRepository::class)]
class Serie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\OneToMany(mappedBy: 'Serie', targetEntity: Temporada::class)]
    private Collection $temporada;

    #[ORM\Column]
    private ?int $fecha_lanzamiento = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $sinopsis = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $poster_src = null;

    #[ORM\ManyToMany(targetEntity: Lista::class, inversedBy: 'serie')]
    private Collection $lista;

    #[ORM\ManyToMany(targetEntity: Genero::class, mappedBy: 'serie')]
    private Collection $genero;

    #[ORM\ManyToMany(targetEntity: Streaming::class, mappedBy: 'serie')]
    private Collection $streamings;

    public function __construct()
    {
        $this->temporada = new ArrayCollection();
        $this->lista = new ArrayCollection();
        $this->genero = new ArrayCollection();
        $this->streamings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * @return Collection<int, Temporada>
     */
    public function getTemporadas(): Collection
    {
        return $this->temporada;
    }

    public function addTemporada(Temporada $temporada): static
    {
        if (!$this->temporada->contains($temporada)) {
            $this->temporada->add($temporada);
            $temporada->setSerie($this);
        }

        return $this;
    }

    public function removeTemporada(Temporada $temporada): static
    {
        if ($this->temporada->removeElement($temporada)) {
            // set the owning side to null (unless already changed)
            if ($temporada->getSerie() === $this) {
                $temporada->setSerie(null);
            }
        }

        return $this;
    }

    public function getFechaLanzamiento(): ?int
    {
        return $this->fecha_lanzamiento;
    }

    public function setFechaLanzamiento(?int $fecha_lanzamiento): static
    {
        $this->fecha_lanzamiento = $fecha_lanzamiento;

        return $this;
    }

    public function getSinopsis(): ?string
    {
        return $this->sinopsis;
    }

    public function setSinopsis(?string $sinopsis): static
    {
        $this->sinopsis = $sinopsis;

        return $this;
    }

    public function getPosterSrc(): ?string
    {
        return $this->poster_src;
    }

    public function setPosterSrc(?string $poster_src): static
    {
        $this->poster_src = $poster_src;

        return $this;
    }

    /**
     * @return Collection<int, Lista>
     */
    public function getLista(): Collection
    {
        return $this->lista;
    }

    public function addLista(Lista $lista): static
    {
        if (!$this->lista->contains($lista)) {
            $this->lista->add($lista);
        }

        return $this;
    }

    public function removeLista(Lista $lista): static
    {
        $this->lista->removeElement($lista);

        return $this;

    }

    /**
     * @return Collection<int, Genero>
     */
    public function getGenero(): Collection
    {
        return $this->genero;
    }

    public function addGenero(Genero $genero): static
    {
        if (!$this->genero->contains($genero)) {
            $this->genero->add($genero);
            $genero->addSerie($this);
        }

        return $this;
    }

    public function removeGenero(Genero $genero): static
    {
        if ($this->genero->removeElement($genero)) {
            $genero->removeSerie($this);
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->nombre;
    }

    /**
     * @return Collection<int, Streaming>
     */
    public function getStreamings(): Collection
    {
        return $this->streamings;
    }

    public function addStreaming(Streaming $streaming): static
    {
        if (!$this->streamings->contains($streaming)) {
            $this->streamings->add($streaming);
            $streaming->addSerie($this);
        }

        return $this;
    }

    public function removeStreaming(Streaming $streaming): static
    {
        if ($this->streamings->removeElement($streaming)) {
            $streaming->removeSerie($this);
        }

        return $this;
    }

    
}
