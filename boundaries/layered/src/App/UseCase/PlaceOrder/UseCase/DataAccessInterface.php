<?php

declare(strict_types=1);

namespace App\UseCase\PlaceOrder\UseCase;

interface DataAccessInterface
{
    public function saveOrder(): void;
}