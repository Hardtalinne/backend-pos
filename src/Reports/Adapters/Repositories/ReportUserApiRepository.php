<?php

namespace App\Reports\Adapters\Repositories;

use App\Reports\UseCases\Contracts\ReportUserRepositoryInterface;
use App\Reports\UseCases\User\UserOutputBoundary;
use App\Shared\Adapters\Contracts\DatabaseDriver;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class ReportUserApiRepository implements ReportUserRepositoryInterface
{
    private DatabaseDriver $databaseDriver;

    public function __construct(
        DatabaseDriver $databaseDriver
    ) {
        $this->databaseDriver = $databaseDriver;
    }

    public function findAllUsers(int $type_user, string $name): ?array
    {
        $type_user = $type_user > 0 ? "in ($type_user)" : 'in(1,2,3)';
        $name = $name != '' ? "and nome ilike '%$name%'" : '';
        $sql = $this->getSql($type_user, $name);


        $rows = $this->databaseDriver
            ->executeSql($sql)
            ->fetchAll();

        if (!$rows) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_NO_CONTENT);
        }
        foreach ($rows as $row)
            $usuarios[] = UserOutputBoundary::build($row);
        return $usuarios;
    }

    private function  getSql(string $type_user, string $name): string
    {
        return "SELECT 
                    * 
                FROM public.usuario 
                WHERE 
                    tipo_usuario $type_user
                    $name";
    }
}
