<?php

namespace App\Entity;

use App\Repository\ActiviteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ActiviteRepository::class)
 */
class Activite
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
    private $nomActivite;

    /**
     * @ORM\OneToMany(targetEntity=Offre::class, mappedBy="activites")
     */
    private $Offre;

    public function __construct()
    {
        $this->Offre = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomActivite(): ?string
    {
        return $this->nomActivite;
    }

    public function setNomActivite(string $nomActivite): self
    {
        $this->nomActivite = $nomActivite;

        return $this;
    }

    /**
     * @return Collection|Offre[]
     */
    public function getOffre(): Collection
    {
        return $this->Offre;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->Offre->contains($offre)) {
            $this->Offre[] = $offre;
        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        $this->Offre->removeElement($offre);

        return $this;
    }
}
