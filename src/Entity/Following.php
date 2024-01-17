<?php

namespace App\Entity;

use App\Repository\FollowingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FollowingRepository::class)]
class Following
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'followings')]
    private Collection $follower;

    public function __construct()
    {
        $this->follower = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFollower(): Collection
    {
        return $this->follower;
    }

    public function addFollower(User $follower): static
    {
        if (!$this->follower->contains($follower)) {
            $this->follower->add($follower);
        }

        return $this;
    }

    public function removeFollower(User $follower): static
    {
        $this->follower->removeElement($follower);

        return $this;
    }
}
