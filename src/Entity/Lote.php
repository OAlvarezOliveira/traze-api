<?php

namespace App\Entity;

use App\Repository\LoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ApiResource(
    normalizationContext: ['groups' => ['lote:read']],
    denormalizationContext: ['groups' => ['lote:write']]
)]
#[ORM\Entity(repositoryClass: LoteRepository::class)]
class Lote
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['lote:read'])]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Groups(['lote:read', 'lote:write'])]
    #[Assert\NotBlank(message: 'El número de lote no puede estar vacío')]
    private ?string $numeroLote = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['lote:read', 'lote:write'])]
    #[Assert\NotNull(message: 'La fecha de fabricación es obligatoria')]
    private ?\DateTimeImmutable $fechaFabricacion = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    #[Groups(['lote:read', 'lote:write'])]
    #[Assert\NotNull(message: 'La fecha de caducidad es obligatoria')]
    #[Assert\GreaterThan(propertyPath: 'fechaFabricacion', message: 'La fecha de caducidad debe ser posterior a la de fabricación')]
    private ?\DateTimeImmutable $fechaCaducidad = null;

    #[ORM\Column]
    #[Groups(['lote:read', 'lote:write'])]
    #[Assert\NotNull]
    #[Assert\Positive(message: 'La cantidad debe ser un número positivo')]
    private ?int $cantidad = null;

    #[ORM\ManyToOne]
    #[Groups(['lote:read', 'lote:write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto = null;

    #[ORM\ManyToOne(inversedBy: 'lotes')]
    #[Groups(['lote:read', 'lote:write'])]
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
