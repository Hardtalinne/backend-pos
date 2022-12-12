<?php

declare(strict_types=1);

namespace App\Login\UseCases\User;

use App\Login\Domain\Exceptions\UserDomainException;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Shared\Domain\Entity\Usuario;
use Exception;

final class GetUserMeUseCase
{
    private UserApiRepositoryInterface $userApiRepository;

    public function __construct(
        UserApiRepositoryInterface $userApiRepository,
    )
    {
        $this->userApiRepository = $userApiRepository;
    }

    public function handle(int $userDataTokenId): ?Usuario
    {
        try {
            return $this->userApiRepository->findUserApiById($userDataTokenId);

        } catch (Exception $exception) {
            if ($exception instanceof UserDomainException) {
                throw $exception;
            }

            throw new Exception("Erro", $exception->getCode());
        }
    }
}
