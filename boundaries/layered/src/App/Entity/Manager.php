<?php

declare(strict_types=1);

namespace App\Entity;

class Manager
{
    public Person $self;

    /**
     * @var Person[]
     */
    public array $employees = [];
}