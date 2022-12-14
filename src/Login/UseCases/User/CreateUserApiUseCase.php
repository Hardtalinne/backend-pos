<?php

declare(strict_types=1);

namespace App\Login\UseCases\User;

use App\Login\Domain\Exceptions\UserDomainException;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Shared\Adapters\Contracts\DatabaseDriver as DatabaseDriver;
use App\Shared\Domain\Constants\HttpStatusCode;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class CreateUserApiUseCase
{
    private UserApiRepositoryInterface $userApiRepository;
    private DatabaseDriver $connection;

    public function __construct(
        UserApiRepositoryInterface $userApiRepository,
        DatabaseDriver $connection
    ) {
        $this->userApiRepository = $userApiRepository;
        $this->connection = $connection;
    }

    public function handle(CreateUserInputBoundary $input): array
    {
        try {
            $this->connection->beginTransaction();

            $this->userApiRepository->saveUserApi($input);

            $this->connection->commit();

            return [
                "message" => "Usuário {$input->getUser()} salvo com sucesso!"
            ];
        } catch (Exception $exception) {
            $this->connection->rollback();

            if ($exception instanceof UserDomainException) {
                throw $exception;
            }

            throw new Exception("Erro ao inserir novo usuário.", $exception->getCode());
        }
    }
}
