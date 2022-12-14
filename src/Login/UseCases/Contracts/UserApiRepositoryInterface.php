<?php

declare(strict_types=1);

namespace App\Login\UseCases\Contracts;

use App\Login\Domain\ValueObjects\User;
use App\Login\UseCases\User\CreateUserInputBoundary;
use App\Shared\Domain\Entity\Usuario;

interface UserApiRepositoryInterface
{
    public function saveUserApi(CreateUserInputBoundary $input): void;
    public function removeUserApi(int $id_usuario): void;

    public function findUserApi(string $user): ?Usuario;

    public function findUserApiById(int $id): ?Usuario;

    public function findAllTypeUser(): ?array;
}
