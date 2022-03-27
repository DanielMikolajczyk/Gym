<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups("show_category")]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    #[Groups("show_category")]
    private $name;

    #[ORM\Column(type: 'boolean')]
    #[Groups("show_category")]
    private $final;

    #[ORM\ManyToMany(targetEntity: Excercise::class, mappedBy: 'categories')]
    private $excercises;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'children')]
    private $parent;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'parent')]
    private $children;

    #[ORM\Column(type: 'boolean')]
    #[Groups("show_category")]
    private $main;


    public function __construct()
    {
        $this->excercises = new ArrayCollection();
        $this->parent = new ArrayCollection();
        $this->children = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->getName();
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


    public function getFinal(): ?bool
    {
        return $this->final;
    }

    public function setFinal(bool $final): self
    {
        $this->final = $final;

        return $this;
    }

    public function getMain(): ?bool
    {
        return $this->main;
    }

    public function setMain(bool $main): self
    {
        $this->main = $main;

        return $this;
    }

    /**
     * @return Collection|Excercise[]
     */
    public function getExcercises(): Collection
    {
        return $this->excercises;
    }

    public function addExcercise(Excercise $excercise): self
    {
        if (!$this->excercises->contains($excercise)) {
            $this->excercises[] = $excercise;
            $excercise->addCategory($this);
        }

        return $this;
    }

    public function removeExcercise(Excercise $excercise): self
    {
        if ($this->excercises->removeElement($excercise)) {
            $excercise->removeCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        $this->parent->removeElement($parent);

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->addParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            $child->removeParent($this);
        }

        return $this;
    }
}
