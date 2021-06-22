<?php
/**
 * wallet-app.
 *
 * (c) Bazyli Bednarz, 2021
 */

namespace App\Entity;

use App\Repository\CurrencyRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=CurrencyRepository::class)
 * @ORM\Table(name="currencies")
 *
 * @UniqueEntity(fields={"name"})
 */
class Currency
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private int $id;

    /**
     * @ORM\Column(
     *     type="string",
     *     length=3,
     * )
     *
     * @Assert\Length(
     *     min="3",
     *     max="3",
     * )
     * @Assert\NotBlank
     */
    private string $name;

    /**
     * @ORM\OneToMany(
     *     targetEntity=Wallet::class,
     *     mappedBy="currency",
     *     fetch="EXTRA_LAZY",
     * )
     */
    private Collection $wallets;

    /**
     * Get currency ID.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get currency name.
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set currency name.
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get wallets.
     *
     * @return Collection
     */
    public function getWallets(): Collection
    {
        return $this->wallets;
    }

    /**
     * Add wallet.
     *
     * @param Wallet $wallet
     */
    public function addWallet(Wallet $wallet): void
    {
        if (!$this->wallets->contains($this)) {
            $this->wallets[] = $wallet;
            $wallet->setCurrency($this);
        }
    }

//    /**
//     * Remove wallet.
//     *
//     * @param Wallet $wallet
//     */
//    public function removeWallet(Wallet $wallet): void
//    {
//        if ($this->wallets->contains($wallet)) {
//            $this->wallets->removeElement($wallet);
//            if ($wallet->getCurrency() === $this) {
//                $wallet->setCurrency(null);
//            }
//        }
//    }
}
