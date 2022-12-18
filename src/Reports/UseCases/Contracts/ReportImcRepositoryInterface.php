<?php

declare(strict_types=1);

namespace App\Reports\UseCases\Contracts;

interface ReportImcRepositoryInterface
{
    public function findTypeUser(int $id_user): int;
    public function findImcs(int $id_user, int $type_user, string $data_avalicao): array;
}
