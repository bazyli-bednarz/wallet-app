<?php
/**
 * Tag service.
 */
namespace App\Service;

use App\Entity\Tag;
use App\Repository\TagRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;

/**
 * Class TagService
 */
class TagService
{
    private TagRepository $tagRepository;

    /**
     * TagService constructor.
     * @param TagRepository $tagRepository
     */
    public function __construct(TagRepository $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * Save.
     *
     * @param Tag $tag
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Tag $tag): void
    {
        $this->tagRepository->save($tag);
    }

    /**
     * Find by title.
     *
     * @param string $name
     *
     * @return Tag|null
     */
    public function findOneByName(string $name): ?Tag
    {
        return $this->tagRepository->findOneByName($name);
    }
}
