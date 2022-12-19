<?php

declare(strict_types=1);

namespace App\Reports\UseCases\Contracts;

interface ReportUserRepositoryInterface
{
    public function findAllUsers(int $type_user, string $name, int $id): ?array;
}
