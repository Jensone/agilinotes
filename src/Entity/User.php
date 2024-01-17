<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: Snippet::class, orphanRemoval: true)]
    private Collection $snippets;

    #[ORM\ManyToMany(targetEntity: Following::class, mappedBy: 'follower')]
    private Collection $followings;

    public function __construct()
    {
        $this->followings = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return Collection<int, Snippet>
     */
    public function getSnippets(): Collection
    {
        return $this->snippets;
    }

    public function addSnippet(Snippet $snippet): static
    {
        if (!$this->snippets->contains($snippet)) {
            $this->snippets->add($snippet);
            $snippet->setAuthor($this);
        }

        return $this;
    }

    public function removeSnippet(Snippet $snippet): static
    {
        if ($this->snippets->removeElement($snippet)) {
            // set the owning side to null (unless already changed)
            if ($snippet->getAuthor() === $this) {
                $snippet->setAuthor(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Following>
     */
    public function getFollowings(): Collection
    {
        return $this->followings;
    }

    public function addFollowing(Following $following): static
    {
        if (!$this->followings->contains($following)) {
            $this->followings->add($following);
            $following->addFollower($this);
        }

        return $this;
    }

    public function removeFollowing(Following $following): static
    {
        if ($this->followings->removeElement($following)) {
            $following->removeFollower($this);
        }

        return $this;
    }
}
