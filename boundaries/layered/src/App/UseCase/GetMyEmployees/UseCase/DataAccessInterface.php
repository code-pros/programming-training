<?php

declare(strict_types=1);

namespace App\UseCase\GetMyEmployees\UseCase;

use App\Entity\Person;

interface DataAccessInterface
{
    /**
     * @return Person[]
     */
    public function getEmployeesByManager(int $managerId): array;

    public function getPerson(int $managerId): Person;
}