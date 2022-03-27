<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(
 *     fields={"Email"},
 *     message="L'email que vous avais indiqué  est déjà utilisé !"
 * )
 */
class User implements UserInterface
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
    private $Nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Email;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(min="8" ,  minMessage="Votre mot de passe doit faire minimum 8 caracters")
     */
    private $Password;

    /**
     * @Assert\EqualTo(propertyPath="Password",message="les deux mot de passe doit etre le meme")
     */
    public $Confirm_Password;

    /**
     * @ORM\Column(type="integer")
     */
    private $numero;

    /**
     * @ORM\Column(type="boolean")
     */
    public $role;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    /**
     * @ORM\ManyToMany(targetEntity=Offre::class, mappedBy="users")
     */
    private $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->Password;
    }

    public function setPassword(string $Password): self
    {
        $this->Password = $Password;

        return $this;
    }
    public function getConfirm_Password(): ?string
    {
        return $this->Confirm_Password;
    }

    public function setConfirm_Password(string $Confirm_Password): self
    {
        $this->Confirm_Password = $Confirm_Password;

        return $this;
    }

    public function getNumero(): ?int
    {
        return $this->numero;
    }

    public function setNumero(int $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getRole(): ?bool
    {
        return $this->role;
    }

    public function setRole(bool $role): self
    {
        $this->role = $role;

        return $this;
    }

    public function getRoles()
    {
        if($this->role==true){
            return array('ROLE_ADMIN');
        }else{
            return array('ROLE_USER');
        }
    }

    public function getSalt()
    {
    }

    public function getUsername()
    {
    }

    public function eraseCredentials()
    {
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int,Offre>
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres[] = $offre;

        }

        return $this;
    }

    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            $offre->removeUser($this);
        }

        return $this;
    }
}
