<?php

namespace App\Entity;

use App\Repository\ServiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ServiceRepository::class)
 */
class Service
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=60)*
     * @Assert\Length(
     *      min = 10,
     *      max = 30,
     *      minMessage = "libelle must be at least {{ limit }} characters long",
     *      maxMessage = "libelle cannot be longer than {{ limit }} characters",
     *      allowEmptyString = false
     * )
     */
    private $libelle;

    /**
     * @ORM\ManyToOne(targetEntity=CategorieService::class, inversedBy="services")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=FourniseurService::class, mappedBy="service")
     */
    private $fourniseursservice;

    public function __construct()
    {
        $this->fourniseursservice = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getCategorie(): ?CategorieService
    {
        return $this->categorie;
    }

    public function setCategorie(?CategorieService $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * @return Collection|FourniseurService[]
     */
    public function getFournisseurs(): Collection
    {
        return $this->fourniseursservice;
    }

    public function addFourniseursservice(FourniseurService $fourniseursservice): self
    {
        if (!$this->fourniseursservice->contains($fourniseursservice)) {
            $this->fourniseursservice[] = $fourniseursservice;
            $fourniseursservice->setService($this);
        }

        return $this;
    }

    public function removeFourniseursservice(FourniseurService $fourniseursservice): self
    {
        if ($this->fourniseursservice->removeElement($fourniseursservice)) {
            // set the owning side to null (unless already changed)
            if ($fourniseursservice->getService() === $this) {
                $fourniseursservice->setService(null);
            }
        }

        return $this;
    }
}
