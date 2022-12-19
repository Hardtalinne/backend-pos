<?php

namespace App\Login\Adapters\Repositories;

use App\Login\Domain\ValueObjects\User;
use App\Login\UseCases\Contracts\UserApiRepositoryInterface;
use App\Login\UseCases\User\CreateUserInputBoundary;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\UpdateStatement;
use App\Shared\Domain\Entity\TipoUsuario;
use App\Shared\Domain\Entity\Usuario;
use DateTimeImmutable;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class UserApiRepository implements UserApiRepositoryInterface
{
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;
    private UpdateStatement $updateStatement;

    public function __construct(
        SelectStatement $selectStatement,
        InsertStatement $insertStatement,
        UpdateStatement $updateStatement
    ) {
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
        $this->updateStatement = $updateStatement;
    }

    public function findUserApi(string $user): ?Usuario
    {
        try {
            $usuario = new Usuario();
            $row = $this->selectStatement
                ->select()
                ->from("public.usuario")
                ->where("usuario", $user)
                ->andWhere("status", 1)
                ->fetchOne();
            if (!$row) {
                return null;
            }
            $usuario->fill($row);
            return $usuario;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function saveUserApi(CreateUserInputBoundary $input): void
    {

        try {
            $values = [
                'nome' => $input->getName(),
                'usuario' => $input->getUser(),
                'senha' => $input->getPassword(),
                'status' => $input->getStatus(),
                'tipo_usuario' => $input->getTypeUser(),
                'email' => $input->getEmail(),
                'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s')
            ];

            $row = $this->selectStatement
                ->select()
                ->from("public.usuario")
                ->where("usuario", $input->getUser())
                ->fetchOne();

            if (!$row) {
                $this->insertStatement
                    ->into("public.usuario")
                    ->values($values)
                    ->insert();
            }

            $this->updateStatement->table("public.usuario")->conditions([
                "id" => $row['id']

            ])->values($values)->update();

            return;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function insertUserApi(CreateUserInputBoundary $input): void
    {
        $values = [
            'nome' => $input->getName(),
            'usuario' => $input->getUser(),
            'senha' => $input->getPassword(),
            'tipo_usuario' => $input->getTypeUser(),
            'email' => $input->getEmail(),
            'created_at' => (new DateTimeImmutable())->format('Y-m-d H:i:s')
        ];

        $this->insertStatement
            ->into("public.usuario")
            ->values($values)
            ->insert();
    }

    public function findUserApiById(int $id): ?Usuario
    {
        try {
            $usuario = new Usuario();
            $row = $this->selectStatement
                ->select(['id', 'nome', 'tipo_usuario', 'usuario'])
                ->from("public.usuario")
                ->where("id", $id)
                ->fetchOne();
            if (!$row) {
                return null;
            }
            $usuario->fill($row);
            return $usuario;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }

    public function findAllTypeUser(): ?array
    {
        try {
            return $this->selectStatement
                ->select()
                ->from("public.tipo_usuario")->fetchAll();
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo tipo de usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
