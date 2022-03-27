<?php

namespace App\Entity;

use App\Repository\DestinationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DestinationRepository::class)
 */
class Destination
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="destination")
     */
    private $offre;
    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;


    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function __construct()
    {
        $this->offre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffre(): Collection
    {
        return $this->offre;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offre->contains($offre)) {
            $this->offre[] = $offre;
            $offre->setDestination($this);
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offre->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getDestination() === $this) {
                $offre->setDestination(null);
            }
        }

        return $this;
    }
}
