<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\RegionRepository")
 */
class Region
{
    use TimestampableEntity;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     * @Gedmo\Slug(fields={"short"})
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Politician", mappedBy="region")
     */
    private $politicians;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $short;

    public function __construct()
    {
        $this->politicians = new ArrayCollection();
    }

    public function __toString(): string
    {
        return (string) $this->getName();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Politician[]
     */
    public function getPoliticians(): Collection
    {
        return $this->politicians;
    }

    public function addPolitician(Politician $politician): self
    {
        if (!$this->politicians->contains($politician)) {
            $this->politicians[] = $politician;
            $politician->setRegion($this);
        }

        return $this;
    }

    public function removePolitician(Politician $politician): self
    {
        if ($this->politicians->contains($politician)) {
            $this->politicians->removeElement($politician);
            // set the owning side to null (unless already changed)
            if ($politician->getRegion() === $this) {
                $politician->setRegion(null);
            }
        }

        return $this;
    }

    public function getShort(): ?string
    {
        return $this->short;
    }

    public function setShort(string $short): self
    {
        $this->short = $short;

        return $this;
    }
}
