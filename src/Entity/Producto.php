<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ApiResource(
    normalizationContext: ['groups' => ['producto:read']],
    denormalizationContext: ['groups' => ['producto:write']]
)]
#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{

    #[ORM\Id, ORM\GeneratedValue, ORM\Column]
    #[Groups(['producto:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['producto:read', 'producto:write'])]
    #[Assert\NotBlank(message: 'El nombre no puede estar vacío')]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $nombre = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups(['producto:read', 'producto:write'])]
    private ?string $descripcion = null;

    #[ORM\Column(length: 100)]
    #[Groups(['producto:read', 'producto:write'])]
    #[Assert\NotBlank(message: 'El código no puede estar vacío')]
    #[Assert\Length(min: 2, max: 100)]
    private ?string $codigo = null;

    #[ORM\Column(length: 100)]
    #[Groups(['producto:read', 'producto:write'])]
    #[Assert\NotBlank(message: 'La categoría no puede estar vacía')]
    private ?string $categoria = null;

    #[ORM\Column]
    #[Groups(['producto:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
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

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): static
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(string $categoria): static
    {
        $this->categoria = $categoria;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}

