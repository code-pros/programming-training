<?php

declare(strict_types=1);

namespace App\UseCase\PlaceOrder\UseCase;

use App\Entity\Order;

class PlaceOrder
{
    private DataAccessInterface $dataAccess;

    public function __construct(DataAccessInterface $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function placeOrder(): void
    {
        $o = new Order();

        $this->dataAccess->saveOrder($o);
    }
}