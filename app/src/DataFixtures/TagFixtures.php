<?php

/**
 * Tag fixtures.
 */

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Persistence\ObjectManager;

/**
 * Class TagFixtures.
 */
class TagFixtures extends AbstractBaseFixtures
{
    /**
     * Load data
     *
     * @param ObjectManager $manager
     */
    public function loadData(ObjectManager $manager): void
    {
        $this->createMany(
            10,
            'tags',
            function ($i) {
                $tag = new Tag();
                $tag->setName($this->faker->word);

                return $tag;
            }
        );
        $this->manager->flush();
    }
}
