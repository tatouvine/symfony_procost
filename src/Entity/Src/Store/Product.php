<?php

namespace App\Entity\Src\Store;

use App\Repository\Src\Store\ProductRepository;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="sto_product")
 */
class Product
{
    /**
     * @var int|null
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id = null;

    /**
     * @var string|null
     * @ORM\Column(type="string",length=255)
     */
    private ?string $name = null;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private ?string $description = null;

    /**
     * @var string|null
     * @ORM\Column(type="text")
     */
    private ?string $descriptionLong = null;

    /**
     * @var string|null
     * @ORM\Column(type="decimal",precision=10,scale=2)
     */
    private ?string $price = null;

    /**
     * @var DateTime
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private string $slug;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Src\Store\Image",cascade={"persist"})
     * @ORM\JoinColumn(nullable=false,name="sto_image_id")
     */
    private ?Image $image = null;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Src\Store\Brand",inversedBy="products")
     * @ORM\JoinColumn(nullable=false,name="sto_brand_id")
     */
    private ?Brand $brand = null;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Src\Store\Color", inversedBy="products")
     * ORM\@ORM\JoinTable(name="sto_product_color")
     */
    private Collection $colors;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Src\Store\Comment",mappedBy="product")
     */
    private $comments;


    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->colors = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Product
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): Product
    {
        $this->description = $description;
        return $this;
    }

    public function getDescriptionLong(): ?string
    {
        return $this->descriptionLong;
    }

    public function setDescriptionLong(?string $descriptionLong): Product
    {
        $this->descriptionLong = $descriptionLong;
        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): Product
    {
        $this->price = $price;
        return $this;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): Product
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(Image $image): self
    {
        $this->image = $image;
        return $this;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(Brand $brand): self
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return Collection| Color[]
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Color $color): self
    {
        if (!$this->colors->contains($color)) {
            $this->colors[] = $color;
        }
        return $this;
    }

    public function removeColor(Color $color): self
    {
        if ($this->colors->contains($color)) {
            $this->colors->removeElement($color);
        }
        return $this;
    }

    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setProduct($this);
        }
        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            if ($comment->getProduct() === $this) {
                $comment->setProduct(null);
            }
        }
        return $this;
    }
}
