<?php

/**
 * Operation class entity.
 */

namespace App\Entity;

use App\Repository\OperationRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OperationRepository::class)
 * @ORM\Table(name="operations")
 */
class Operation
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime")
     */
    private $time;

    /**
     * @ORM\Column(type="float")
     */
    private $value;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="operations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

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
     * @return float|null Value
     */
    public function getValue(): ?float
    {
        return $this->value;
    }

    /**
     * Set operation value.
     *
     * @param float $value Value
     */
    public function setValue(float $value): void
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
}
