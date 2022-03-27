<?php

namespace App\Entity;

use App\Repository\OffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OffreRepository::class)
 */
class Offre
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @var \DateTime

     * @ORM\Column(name="date_debut", type="date", nullable=false)
     */
    private $dateDebut;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_fin", type="date", nullable=false)
     */
    private $dateFin;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomOffre;

    /**
     * @ORM\Column(type="integer")
     */
    private $prixOffre;

    /**
     * @ORM\ManyToOne(targetEntity=Destination::class, inversedBy="offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $destination;

    /**
     * @ORM\ManyToOne(targetEntity=Activite::class, inversedBy="Offre")
     * @ORM\JoinColumn(nullable=false)
     */
    private $activites;

    /**
     * @ORM\Column(name="image", type="string", length=255, nullable=false)
     */
    private $image;
    /**
     * @ORM\Column(type="integer")
     */
    private $nbdevues;
    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="offres")
     */
    private $users;

    /**
     * @return Collection<int,User>
     */
    public function getUsers() :Collection
    {
        return $this->users;
    }
   public function addUser(User $user):self
   {
       if(!$this->users->contains($user)){
           $this->users[]=$user;
           $user->addOffre($this);
       }
       return $this;
   }
   public  function  removeUser(User $user) :self
   {
       if($this->users->removeElement($user))
       {
           $user->removeOffre($this);
       }
       return $this;
   }
    /**
     * @return mixed
     */
    public function getNbdevues()
    {
        return $this->nbdevues;
    }

    /**
     * @param mixed $nbdevues
     */
    public function setNbdevues($nbdevues): void
    {
        $this->nbdevues = $nbdevues;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomOffre(): ?string
    {
        return $this->nomOffre;
    }

    public function setNomOffre(string $nomOffre): self
    {
        $this->nomOffre = $nomOffre;

        return $this;
    }

    public function getPrixOffre(): ?int
    {
        return $this->prixOffre;
    }

    public function setPrixOffre(int $prixOffre): self
    {
        $this->prixOffre = $prixOffre;

        return $this;
    }

    public function getDestination(): ?Destination
    {
        return $this->destination;
    }

    public function setDestination(?Destination $destination): self
    {
        $this->destination = $destination;

        return $this;
    }

    public function getActivites(): ?Activite
    {
        return $this->activites;
    }

    public function setActivites(?Activite $activite): self
    {
        $this->activites = $activite;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->dateDebut;
    }

    public function setDateDebut(\DateTimeInterface $datee): self
    {
        $this->dateDebut = $datee;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->dateFin;
    }

    public function setDateFin(\DateTimeInterface $datee): self
    {
        $this->dateFin = $datee;

        return $this;
    }
   
}
