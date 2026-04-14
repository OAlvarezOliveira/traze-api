<?php

namespace App\Entity;

use App\Repository\MovimientoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;


#[ApiResource(
    normalizationContext: ['groups' => ['movimiento:read']],
    denormalizationContext: ['groups' => ['movimiento:write']]
)]
#[ORM\Entity(repositoryClass: MovimientoRepository::class)]
class Movimiento
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['movimiento:read'])]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['movimiento:read', 'movimiento:write'])]
    #[Assert\NotBlank(message: 'El tipo no puede estar vacío')]
    #[Assert\Choice(choices: ['entrada', 'salida', 'transformacion'], message: 'El tipo debe ser entrada, salida o transformacion')]
    private ?string $tipo = null;

    #[ORM\Column]
    #[Groups(['movimiento:read', 'movimiento:write'])]
    #[Assert\NotNull]
    #[Assert\Positive(message: 'La cantidad debe ser un número positivo')]
    private ?int $cantidad = null;

    #[ORM\Column]
    #[Groups(['movimiento:read', 'movimiento:write'])]
    #[Assert\NotNull(message: 'La fecha es obligatoria')]
    private ?\DateTimeImmutable $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'movimientos')]
    #[Groups(['movimiento:read', 'movimiento:write'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Lote $lote = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['movimiento:read', 'movimiento:write'])]
    private ?string $descripcion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): static
    {
        $this->tipo = $tipo;

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

    public function getFecha(): ?\DateTimeImmutable
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeImmutable $fecha): static
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getLote(): ?Lote
    {
        return $this->lote;
    }

    public function setLote(?Lote $lote): static
    {
        $this->lote = $lote;

        return $this;
    }
}
