<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Entity;

use App\Repository\WalletRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class wallet.
 *
 * @ORM\Entity(repositoryClass=WalletRepository::class)
 * @ORM\Table(name="wallets")
 *
 * @UniqueEntity(fields={"name"})
 */
class Wallet
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=45,
     * )
     *
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     * @Assert\NotBlank
     */
    private string $name;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=45,
     * )
     * @Assert\Type(type="string")
     * @Assert\Length(
     *     min="3",
     *     max="45",
     * )
     *
     * @Gedmo\Slug(fields={"name"})
     */
    private string $code;

    /**
     * @ORM\ManyToOne(
     *     targetEntity=Currency::class,
     *     inversedBy="wallets"
     * )
     * @ORM\JoinColumn(nullable=false)
     *
     * @Assert\Type(type="App\Entity\Currency")
     * @Assert\NotNull
     */
    private ?Currency $currency;

    /**
     * @var Collection|ArrayCollection
     *
     * @ORM\OneToMany(
     *     targetEntity=Operation::class,
     *     mappedBy="wallet",
     *     fetch="LAZY",
     * )
     */
    private Collection $operations;

    /**
     * Author.
     *
     * @ORM\ManyToOne(targetEntity=User::class, fetch="EXTRA_LAZY")
     */
    private ?User $author;

    /**
     * @ORM\Column(type="integer")
     */
    private int $balance;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->operations = new ArrayCollection();
        $this->balance = 0;
    }

    /**
     * Get ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get slug.
     *
     * @return string|null
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Set slug.
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Getter for currency.
     *
     * @return Currency|null
     */
    public function getCurrency(): ?Currency
    {
        return $this->currency;
    }

    /**
     * Setter for currency.
     *
     * @param Currency|null $currency Category
     */
    public function setCurrency(?Currency $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * Get operations.
     *
     * @return Collection|Operation[]
     */
    public function getOperations(): Collection
    {
        return $this->operations;
    }

    /**
     * Add operation.
     *
     * @param Operation $operation
     *
     * @return $this
     */
    public function addOperation(Operation $operation): self
    {
        if (!$this->operations->contains($operation)) {
            $this->operations[] = $operation;
            $operation->setWallet($this);
        }

        return $this;
    }

    /**
     * Remove operation.
     *
     * @param Operation $operation
     *
     * @return $this
     */
    public function removeOperation(Operation $operation): self
    {
        if ($this->operations->removeElement($operation)) {
            // set the owning side to null (unless already changed)
            if ($operation->getWallet() === $this) {
                $operation->setWallet(null);
            }
        }

        return $this;
    }

    /**
     * Get author.
     *
     * @return User|null
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * Set author.
     *
     * @param User|null $author
     */
    public function setAuthor(?User $author): void
    {
        $this->author = $author;
    }

    /**
     * Get wallet balance.
     *
     * @return int|null
     */
    public function getBalance(): ?int
    {
        return $this->balance;
    }

    /**
     * Set wallet balance.
     *
     * @param int $balance
     */
    public function setBalance(int $balance): void
    {
        $this->balance = $balance;
    }
}
