<?php

declare(strict_types=1);

namespace App\Login\UseCases\User;

use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use Exception;

final class DeleteUserApiUseCase
{
    private UserApiRepositoryInterface $userApiRepository;

    public function __construct(
        UserApiRepositoryInterface $userApiRepository
    ) {
        $this->userApiRepository = $userApiRepository;
    }

    public function handle(int $id_usuario): array
    {
        try {
            $this->userApiRepository->removeUserApi($id_usuario);

            return [
                "message" => "Usuário removido com sucesso!"
            ];
        } catch (Exception $exception) {

            throw new Exception("Erro ao remover o usuário.", $exception->getCode());
        }
    }
}
