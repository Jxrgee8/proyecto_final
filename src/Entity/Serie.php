<?php

namespace App\Entity;

use App\Repository\SerieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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
    private Collection $temporadas;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $fecha_lanzamiento = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY, nullable: true)]
    private ?array $plataforma = null;

    #[ORM\Column(type: Types::SIMPLE_ARRAY)]
    private array $genero = [];

    #[ORM\ManyToOne(inversedBy: 'series')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Lista $Lista = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $sinopsis = null;

    public function __construct()
    {
        $this->temporadas = new ArrayCollection();
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
        return $this->temporadas;
    }

    public function addTemporada(Temporada $temporada): static
    {
        if (!$this->temporadas->contains($temporada)) {
            $this->temporadas->add($temporada);
            $temporada->setSerie($this);
        }

        return $this;
    }

    public function removeTemporada(Temporada $temporada): static
    {
        if ($this->temporadas->removeElement($temporada)) {
            // set the owning side to null (unless already changed)
            if ($temporada->getSerie() === $this) {
                $temporada->setSerie(null);
            }
        }

        return $this;
    }

    public function getFechaLanzamiento(): ?\DateTimeInterface
    {
        return $this->fecha_lanzamiento;
    }

    public function setFechaLanzamiento(?\DateTimeInterface $fecha_lanzamiento): static
    {
        $this->fecha_lanzamiento = $fecha_lanzamiento;

        return $this;
    }

    public function getPlataforma(): ?array
    {
        return $this->plataforma;
    }

    public function setPlataforma(?array $plataforma): static
    {
        $this->plataforma = $plataforma;

        return $this;
    }

    public function getGenero(): array
    {
        return $this->genero;
    }

    public function setGenero(array $genero): static
    {
        $this->genero = $genero;

        return $this;
    }

    public function getLista(): ?Lista
    {
    return $this->Lista;
    }

    public function setLista(?Lista $Lista): static
    {
    $this->Lista = $Lista;

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

}
