<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Entity;

use App\Repository\OperationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 * @ORM\Table(name="operations")
 *
 * @UniqueEntity(fields={"name"})
 */
class Operation
{
    /**
     * Primary key.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * Name.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\NotBlank
     * @Assert\Length(
     *     min="3",
     *     max="255",
     * )
     */
    private string $name;

    /**
     * Created at.
     *
     * @var DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     *
     * @Assert\Type(type="\DateTimeInterface")
     *
     * @Gedmo\Timestampable(on="create")
     */
    private DateTimeInterface $time;

    /**
     * @ORM\Column(type="integer")
     */
    private int $value;

    /**
     * @ORM\ManyToOne(
     *     targetEntity=Category::class,
     *     inversedBy="operations"
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Category")
     * @Assert\NotNull
     */
    private ?Category $category;

    /**
     * @ORM\ManyToOne(
     *     targetEntity=Wallet::class,
     *     inversedBy="operations"
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Wallet")
     * @Assert\NotNull
     */
    private ?Wallet $wallet;

    /**
     * Tags.
     *
     * @var Collection
     *
     * @ORM\ManyToMany(
     *     targetEntity=Tag::class,
     *     inversedBy="operations",
     * )
     * @ORM\JoinTable(name="operations_tags")
     */
    private Collection $tags;

    /**
     * Operation constructor.
     */
    public function __construct()
    {
        $this->tags = new ArrayCollection();
    }

    /**
     * Slug.
     *
     * @var string
     *
     * @ORM\Column(
     *     type="string",
     *     length=255,
     * )
     *
     * @Gedmo\Slug(fields={"name"})
     */
    private string $code;

    /**
     * Get ID for operation.
     *
     * @return int|null ID
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get operation name.
     *
     * @return string|null Name
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set operation name.
     *
     * @param string $name Name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get date of creation.
     *
     * @return DateTimeInterface|null Time
     */
    public function getTime(): ?DateTimeInterface
    {
        return $this->time;
    }

    /**
     * Set date of creation.
     *
     * @param DateTimeInterface $time Time
     */
    public function setTime(DateTimeInterface $time): void
    {
        $this->time = $time;
    }

    /**
     * Get operation value.
     *
     * @return int|null Value
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * Set operation value.
     *
     * @param int $value Value
     */
    public function setValue(int $value): void
    {
        $this->value = $value;
    }

    /**
     * Getter for category containing operation.
     *
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * Setter for category containing operation.
     *
     * @param Category|null $category Category
     */
    public function setCategory(?Category $category): void
    {
        $this->category = $category;
    }

    /**
     * Getter for wallet containing operation.
     *
     * @return Wallet|null
     */
    public function getWallet(): ?Wallet
    {
        return $this->wallet;
    }

    /**
     * Setter for wallet containing operation.
     *
     * @param Wallet|null $wallet Wallet
     */
    public function setWallet(?Wallet $wallet): void
    {
        $this->wallet = $wallet;
    }

    /**
     * Getter for tags.
     *
     * @return Collection|Tag[] Tags collection
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    /**
     * Add tag to collection.
     *
     * @param Tag $tag Tag entity
     */
    public function addTag(Tag $tag): void
    {
        if (!($this->tags->contains($tag))) {
            $this->tags[] = $tag;
        }
    }

    /**
     * Remove tag from collection.
     *
     * @param Tag $tag Tag entity
     */
    public function removeTag(Tag $tag): void
    {
        if ($this->tags->contains($tag)) {
            $this->tags->removeElement($tag);
        }
    }

    /**
     * Get code.
     *
     * @return ?string
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set code.
     *
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }
}
