<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $article_id = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

/*     #[ORM\ManyToOne(inversedBy: 'comments')]
 */    /* #[ORM\JoinColumn(name: 'article_id', referencedColumnName: 'id', nullable: false)]
    private ?Article $article = null; */


    #[ORM\ManyToOne(inversedBy: 'comments')]
private ?Article $article = null;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $username;

    #[ORM\ManyToOne(inversedBy: 'comments')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id', nullable: true)]
    private ?User $user = null;  // Remplace UserInterface par User

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserCommentedId(): ?int
    {
        return $this->user ? $this->user->getId() : null;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }
    public function getArticleId(): ?int
    {
        return $this->article_id;
    }

    public function setArticleId(int $article_id): static
    {
        $this->article_id = $article_id;

        return $this;
    }

    public function getUserLastName(): ?string
    {
        return $this->user ? $this->user->getLastName() : null;
    }

    public function getUserFirstName(): ?string
    {
        return $this->user ? $this->user->getFirstName() : null;
    }

    public function getUserEmail(): ?string
    {
        return $this->user ? $this->user->getEmail() : null;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }



    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(?Article $article): static
    {
        $this->article = $article;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
