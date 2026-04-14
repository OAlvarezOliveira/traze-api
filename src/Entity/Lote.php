<?php

namespace App\Entity;

use App\Repository\LoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LoteRepository::class)]
class Lote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $numeroLote = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fechaFabricacion = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $fechaCaducidad = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto = null;

    #[ORM\ManyToOne(inversedBy: 'lotes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Proveedor $proveedor = null;

    /**
     * @var Collection<int, Movimiento>
     */
    #[ORM\OneToMany(targetEntity: Movimiento::class, mappedBy: 'lote', orphanRemoval: true)]
    private Collection $movimientos;

    public function __construct()
    {
        $this->movimientos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroLote(): ?string
    {
        return $this->numeroLote;
    }

    public function setNumeroLote(string $numeroLote): static
    {
        $this->numeroLote = $numeroLote;

        return $this;
    }

    public function getFechaFabricacion(): ?\DateTimeImmutable
    {
        return $this->fechaFabricacion;
    }

    public function setFechaFabricacion(\DateTimeImmutable $fechaFabricacion): static
    {
        $this->fechaFabricacion = $fechaFabricacion;

        return $this;
    }

    public function getFechaCaducidad(): ?\DateTimeImmutable
    {
        return $this->fechaCaducidad;
    }

    public function setFechaCaducidad(\DateTimeImmutable $fechaCaducidad): static
    {
        $this->fechaCaducidad = $fechaCaducidad;

        return $this;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): static
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): static
    {
        $this->producto = $producto;

        return $this;
    }

    public function getProveedor(): ?Proveedor
    {
        return $this->proveedor;
    }

    public function setProveedor(?Proveedor $proveedor): static
    {
        $this->proveedor = $proveedor;
        return $this;
    }

    /**
     * @return Collection<int, Movimiento>
     */
    public function getMovimientos(): Collection
    {
        return $this->movimientos;
    }

    public function addMovimiento(Movimiento $movimiento): static
    {
        if (!$this->movimientos->contains($movimiento)) {
            $this->movimientos->add($movimiento);
            $movimiento->setLote($this);
        }

        return $this;
    }

    public function removeMovimiento(Movimiento $movimiento): static
    {
        if ($this->movimientos->removeElement($movimiento)) {
            // set the owning side to null (unless already changed)
            if ($movimiento->getLote() === $this) {
                $movimiento->setLote(null);
            }
        }

        return $this;
    }
}
