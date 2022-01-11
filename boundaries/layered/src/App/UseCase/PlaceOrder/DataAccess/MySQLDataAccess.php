<?php

declare(strict_types=1);

namespace App\UseCase\PlaceOrder\DataAccess;

use App\UseCase\PlaceOrder\UseCase\DataAccessInterface;
use PDO;

class MySQLDataAccess implements DataAccessInterface
{

    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function saveOrder(): void
    {
        // TODO: Implement saveOrder() method.
    }
}