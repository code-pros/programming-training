<?php

declare(strict_types=1);

namespace App\UseCase\GetMyEmployees\UseCase;

use App\Entity\Manager;

class GetMyEmployees
{
    private DataAccessInterface $dataAccess;

    public function __construct(DataAccessInterface $dataAccess)
    {
        $this->dataAccess = $dataAccess;
    }

    public function get(int $managerId): GetMyEmployeesOutputData
    {
        $manager = new Manager();
        $manager->self = $this->dataAccess->getPerson($managerId);
        $manager->employees = $this->dataAccess->getEmployeesByManager($managerId);

        $data = new GetMyEmployeesOutputData();
        $data->managerName = $manager->self->name;
        $data->employees = $manager->employees;

        return $data;
    }
}