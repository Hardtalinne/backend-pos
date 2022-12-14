<?php

declare(strict_types=1);

namespace App\Login\UseCases\User;

use App\Login\Domain\Exceptions\UserDomainException;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Shared\Domain\Entity\TipoUsuario;
use Exception;

final class GetTypesUserUseCase
{
    private UserApiRepositoryInterface $userApiRepository;

    public function __construct(
        UserApiRepositoryInterface $userApiRepository,
    ) {
        $this->userApiRepository = $userApiRepository;
    }

    public function handle(): ?array
    {
        return $this->userApiRepository->findAllTypeUser();
    }
}
