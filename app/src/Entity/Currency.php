<?php
/**
 * Currency entity.
 */
namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 * @ORM\Table(name="currencies")
 *
 * @UniqueEntity(fields={"name"})
 */
class Currency
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(
     *     type="string",
     *      length=3,
     * )
     *
     * @Assert\Length(
     *     min="3",
     *     max="3",
     * )
     * @Assert\NotBlank
     */
    private $name;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity=Wallet::class,
     *     mappedBy="currency",
     *     fetch="EXTRA_LAZY",
     * )
     */
    private Collection $wallets;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return Collection
     */
    public function getWallets(): Collection
    {
        return $this->wallets;
    }

    public function addWallet(Wallet $wallet): void {
        if (!$this->wallets->contains($this)) {
            $this->wallets[] = $wallet;
            $wallet->setCurrency($this);
        }
    }

    public function removeWallet(Wallet $wallet) {
        if ($this->wallets->contains($wallet)) {
            $this->wallets->removeElement($wallet);
            if($wallet->getCurrency() === $this) {
                $wallet->setCurrency(null);
            }
        }
    }

}
