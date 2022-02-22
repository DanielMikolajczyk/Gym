<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    #[Assert\NotBlank]
    private $name;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $parent;

    #[ORM\Column(type: 'json', nullable: true)]
    private $childs = [];

    #[ORM\Column(type: 'boolean')]
    private $final;

    #[ORM\ManyToMany(targetEntity: Excercise::class, mappedBy: 'categories')]
    private $excercises;

    public function __construct()
    {
        $this->excercises = new ArrayCollection();
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

    public function getParent(): ?string
    {
        return $this->parent;
    }

    public function setParent(?string $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    public function getChilds(): ?array
    {
        return $this->childs;
    }

    public function setChilds(?array $childs): self
    {
        $this->childs = $childs;

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

    #[Assert\Callback]
    public function validate(ExecutionContextInterface $context, $payload)
    {
 
    }
}
