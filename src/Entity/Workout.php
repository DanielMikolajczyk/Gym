<?php

namespace App\Entity;

use App\Repository\WorkoutRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: WorkoutRepository::class)]
class Workout
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'workouts')]
    private $Users;

    #[ORM\Column(type: 'json')]
    private $plan = [];

    #[ORM\ManyToMany(targetEntity: UserGroup::class, mappedBy: 'workouts')]
    private $userGroups;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\ManyToOne(targetEntity: WorkoutKind::class, inversedBy: 'workouts')]
    #[ORM\JoinColumn(nullable: false)]
    private $workoutKind;

    public function __construct()
    {
        $this->Users = new ArrayCollection();
        $this->userGroups = new ArrayCollection();
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

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->Users;
    }

    public function addUser(User $user): self
    {
        if (!$this->Users->contains($user)) {
            $this->Users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->Users->removeElement($user);

        return $this;
    }

    public function getPlan(): ?array
    {
        return $this->plan;
    }

    public function setPlan(array $plan): self
    {
        $this->plan = $plan;

        return $this;
    }

    /**
     * @return Collection|UserGroup[]
     */
    public function getUserGroups(): Collection
    {
        return $this->userGroups;
    }

    public function addUserGroup(UserGroup $userGroup): self
    {
        if (!$this->userGroups->contains($userGroup)) {
            $this->userGroups[] = $userGroup;
            $userGroup->addWorkout($this);
        }

        return $this;
    }

    public function removeUserGroup(UserGroup $userGroup): self
    {
        if ($this->userGroups->removeElement($userGroup)) {
            $userGroup->removeWorkout($this);
        }

        return $this;
    }

    public function getWorkoutKind(): ?WorkoutKind
    {
        return $this->workoutKind;
    }

    public function setWorkoutKind(?WorkoutKind $workoutKind): self
    {
        $this->workoutKind = $workoutKind;

        return $this;
    }
}
