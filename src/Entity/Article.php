<?php

namespace App\Entity;

use App\Model\TimestampedInterface;
use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;



#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article implements TimestampedInterface
{


    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $featured_image_id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $slug = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    #[ORM\Column(length: 255)]
    private ?string $featured_text = null;





    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTime $created_at = null;


    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTime $updated_at = null;

    #[ORM\Column]
    private ?bool $is_active = null;


    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Image::class)]
    private Collection $image;

    #[ORM\ManyToOne(inversedBy: 'articles')]
    private ?Category $category = null;

    #[ORM\OneToMany(mappedBy: 'article', targetEntity: Comment::class)]
    private Collection $Comment;


    public function __construct()
    {
        $this->image = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->updated_at = new \DateTime();
        $this->featured_image_id = 0;
        $this->is_active = true;
        $this->Comment = new ArrayCollection();
    }


    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFeaturedImageId(): ?int
    {
        return $this->featured_image_id;
    }

    public function setFeaturedImageId(int $featured_image_id): static
    {
        $this->featured_image_id = $featured_image_id;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(?string $slug): static
    {
        $this->slug = $slug;

        return $this;
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

    public function getFeaturedText(): ?string
    {
        return $this->featured_text;
    }

    public function setFeaturedText(string $featured_text): static
    {
        $this->featured_text = $featured_text;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }
    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }



    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }





    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }



    public function isIsActive(): ?bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;

        return $this;
    }

    /**
     * @return Collection<int, Image>
     */
    public function getImage(): Collection
    {
        return $this->image;
    }

    public function addImage(Image $image): static
    {
        if (!$this->image->contains($image)) {
            $this->image->add($image);
            $image->setArticle($this);
        }

        return $this;
    }

    public function removeImage(Image $image): static
    {
        if ($this->image->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getArticle() === $this) {
                $image->setArticle(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $Category): static
    {
        $this->category = $Category;

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComment(): Collection
    {
        return $this->Comment;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->Comment->contains($comment)) {
            $this->Comment->add($comment);
            $comment->setArticle($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->Comment->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getArticle() === $this) {
                $comment->setArticle(null);
            }
        }

        return $this;
    }
}
