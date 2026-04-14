<?php

namespace App\Entity;

use App\Repository\ProveedorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;



#[ApiResource(
    normalizationContext: ['groups' => ['proveedor:read']],
    denormalizationContext: ['groups' => ['proveedor:write']]
)]
#[ORM\Entity(repositoryClass: ProveedorRepository::class)]
class Proveedor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Groups(['proveedor:read'])]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\Column(length: 255)]
    #[Groups(['proveedor:read', 'proveedor:write'])]
    #[Assert\NotBlank(message: 'El nombre no puede estar vacío')]
    #[Assert\Length(min: 2, max: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['proveedor:read', 'proveedor:write'])]
    private ?string $contacto = null;

    #[ORM\Column(length: 100)]
    #[Groups(['proveedor:read', 'proveedor:write'])]
    #[Assert\NotBlank(message: 'El país no puede estar vacío')]
    private ?string $pais = null;

    #[ORM\Column(length: 180, nullable: true)]
    #[Groups(['proveedor:read', 'proveedor:write'])]
    #[Assert\Email(message: 'El email {{ value }} no es válido')]
    private ?string $email = null;

    #[ORM\Column(length: 50, nullable: true)]
    #[Groups(['proveedor:read', 'proveedor:write'])]
    private ?string $telefono = null;

    /**
     * @var Collection<int, Lote>
     */
    #[ORM\OneToMany(targetEntity: Lote::class, mappedBy: 'proveedor')]
    private Collection $lotes;

    public function __construct()
    {
        $this->lotes = new ArrayCollection();
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

    public function getContacto(): ?string
    {
        return $this->contacto;
    }

    public function setContacto(?string $contacto): static
    {
        $this->contacto = $contacto;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): static
    {
        $this->pais = $pais;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): static
    {
        $this->telefono = $telefono;

        return $this;
    }
    /**
     * @return Collection<int, Lote>
     */
    public function getLotes(): Collection
    {
        return $this->lotes;
    }

    public function addLote(Lote $lote): static
    {
        if (!$this->lotes->contains($lote)) {
            $this->lotes->add($lote);
            $lote->setProveedor($this);
        }

        return $this;
    }

    public function removeLote(Lote $lote): static
    {
        if ($this->lotes->removeElement($lote)) {
            // set the owning side to null (unless already changed)
            if ($lote->getProveedor() === $this) {
                $lote->setProveedor(null);
            }
        }

        return $this;
    }
}
