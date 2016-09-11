<?php

declare(strict_types=1);

namespace Psi\Component\Description\Descriptor;

use Psi\Component\Description\DescriptorInterface;

class DateTimeDescriptor implements DescriptorInterface
{
    private $key;
    private $dateTime;

    public function __construct(string $key, \DateTime $dateTime)
    {
        $this->dateTime = $dateTime;
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function getKey(): string
    {
        return $this->key;
    }

    /**
     * Return the \DateTime object.
     */
    public function getDateTime(): \DateTime
    {
        return $this->dateTime;
    }

    /**
     * Shortcut for \DateTime#format($format).
     *
     * @param string $format
     */
    public function format(string $format): string
    {
        return $this->dateTime->format($format);
    }
}
