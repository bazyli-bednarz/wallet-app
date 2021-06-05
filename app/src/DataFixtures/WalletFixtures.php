<?php
/**
 * Wallet fixture.
 */

namespace App\DataFixtures;

use App\Entity\Wallet;
use Doctrine\Persistence\ObjectManager;

/**
 * Class WalletFixtures.
 */
class WalletFixtures extends AbstractBaseFixtures
{
    /**
     * Load data.
     *
     * @param ObjectManager $manager Object manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(10, 'wallets', function () {
            $wallet = new Wallet();

            $choice = $this->faker->numberBetween(1, 3);
            if (1 === $choice) {
                $wallet->setName('Wallet'.' '.$this->faker->randomNumber(2));
            } elseif (2 === $choice) {
                $creditCardType = $this->faker->creditCardType();
                $wallet->setName($creditCardType.' '.$this->faker->creditCardNumber(''.$creditCardType.'', true, ' '));
            } elseif (3 === $choice) {
                $wallet->setName(ucfirst($this->faker->word()).' '.$this->faker->emoji());
            }
            $wallet->setCurrency($this->getRandomReference('currencies'));

            return $wallet;
        });

        $manager->flush();
    }
}
