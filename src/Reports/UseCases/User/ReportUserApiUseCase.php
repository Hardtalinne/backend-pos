<?php

declare(strict_types=1);

namespace App\Reports\UseCases\User;

use App\Reports\UseCases\Contracts\ReportUserRepositoryInterface;

final class ReportUserApiUseCase
{
    private ReportUserRepositoryInterface $reportUser;

    public function __construct(
        ReportUserRepositoryInterface $reportUser
    ) {
        $this->reportUser = $reportUser;
    }

    public function handle(int $type_user, string $name, int $id): ?array
    {
        $Users = $this->reportUser->findAllUsers($type_user, $name, $id);

        return $Users;
    }
}
