<?php

declare(strict_types=1);

namespace App\Reports\UseCases\User;

use App\Reports\UseCases\Contracts\ReportImcRepositoryInterface;

final class ReportImcApiUseCase
{
    private ReportImcRepositoryInterface $reportUser;

    public function __construct(
        ReportImcRepositoryInterface $reportUser
    ) {
        $this->reportUser = $reportUser;
    }

    public function handle(int $id_user, string $data_avalicao): array
    {
        $type_user = $this->reportUser->findTypeUser($id_user);

        return $this->reportUser->findImcs($id_user, $type_user, $data_avalicao);
    }
}
