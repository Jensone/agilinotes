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

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'followers')]
    private Collection $followers;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'followings')]
    private Collection $followings;

    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->followings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollowers(User $followers): static
    {
        if (!$this->followers->contains($followers)) {
            $this->followers->add($followers);
        }

        return $this;
    }

    public function removeFollowers(User $followers): static
    {
        $this->followers->removeElement($followers);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFollowings(): Collection
    {
        return $this->followings;
    }

    public function addFollowing(User $following): static
    {
        if (!$this->followings->contains($following)) {
            $this->followings->add($following);
        }

        return $this;
    }

    public function removeFollowing(User $following): static
    {
        $this->followings->removeElement($following);

        return $this;
    }
}
