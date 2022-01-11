<?php

declare(strict_types=1);

namespace App\UseCase\GetMyEmployees\DataAccess;

use App\Entity\Person;
use App\UseCase\GetMyEmployees\UseCase\DataAccessInterface;
use PDO;

class MySQLDataAccess implements DataAccessInterface
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getEmployeesByManager(int $managerId): array
    {
        $data = [];

        $sth = $this->pdo->prepare("SELECT * FROM employees WHERE manager_id = ?");
        $sth->execute([$managerId]);
        while ($row = $sth->fetch()) {
            $p = new Person();
            $p->name = $row['name'];
            $data[] = $p;
        }

        return $data;
    }

    public function getPerson(int $managerId): Person
    {
        $sth = $this->pdo->prepare("SELECT * FROM employees WHERE id = ?");
        $sth->execute([$managerId]);
        $data = $sth->fetch();

        $p = new Person();
        $p->name = $data['name'];
        return $p;
    }
}