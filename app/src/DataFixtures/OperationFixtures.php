<?php
/**
 * Operation fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Operation;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class OperationFixtures.
 */
class OperationFixtures extends AbstractBaseFixtures implements DependentFixtureInterface
{
    /**
     * Faker.
     */
    protected Generator $faker;

    /**
     * Persistence object manager.
     */
    protected ObjectManager $manager;

    /**
     * Generates an array of dependencies.
     *
     * @return string[] Array of dependencies
     */
    public function getDependencies(): array
    {
        return [WalletFixtures::class, CategoryFixtures::class];
    }

    /**
     * Load data.
     *
     * @param ObjectManager $manager Persistence object manager
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(100, 'operations', function ($i) {
            $operation = new Operation();
            $operation->setName($this->faker->sentence);
            $operation->setTime($this->faker->dateTimeBetween('-100 days', '-1 days'));
            $operation->setValue($this->faker->numberBetween(1, 99999));
            $operation->setCategory($this->getRandomReference('categories'));
            $operation->setWallet($this->getRandomReference('wallets'));

            $tags = $this->getRandomReferences(
                'tags',
                $this->faker->numberBetween(0,5)
            );
            foreach ($tags as $tag) {
                $operation->addTag($tag);
            }

            return $operation;
        });

        $this->manager->flush();
    }
}
