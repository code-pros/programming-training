<?php

declare(strict_types=1);

namespace App\UseCase\GetMyEmployees\UseCase;

use App\Entity\Person;

class GetMyEmployeesOutputData
{
    public string $managerName;

    /**
     * @var Person[]
     */
    public array $employees = [];
}