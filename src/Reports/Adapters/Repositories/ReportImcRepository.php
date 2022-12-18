<?php

namespace App\Reports\Adapters\Repositories;

use App\Reports\UseCases\Contracts\ReportImcRepositoryInterface;
use App\Reports\UseCases\User\ImcOutputBoundary;
use App\Reports\UseCases\User\UserOutputBoundary;
use App\Shared\Adapters\Contracts\DatabaseDriver;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use App\Shared\Domain\Entity\Usuario;
use App\Shared\Helpers\Util;
use DateTimeImmutable;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class ReportImcRepository implements ReportImcRepositoryInterface
{
    private SelectStatement $selectStatement;
    private DatabaseDriver $databaseDriver;

    public function __construct(
        SelectStatement $selectStatement,
        DatabaseDriver $databaseDriver
    ) {
        $this->selectStatement = $selectStatement;
        $this->databaseDriver = $databaseDriver;
    }

    public function findTypeUser(int $id_user): int
    {

        $rows = $this->selectStatement
            ->select()
            ->from("public.usuario")
            ->where("id", $id_user)
            ->fetchOne();
        if (!$rows) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_NO_CONTENT);
        }
        return $rows['tipo_usuario'];
    }

    public function findImcs(int $id_user, int $type_user, string $data_avalicao): array
    {
        $colun =  $type_user != 3 ? 'id_profissional' : 'id_aluno';
        $data_avalicao = $data_avalicao != 0 ? "and to_char(i.data, 'YYYY-MM-DD') >= '$data_avalicao'" : '';
        $sql = $this->getSQL($colun, $id_user, $data_avalicao);

        $rows = $this->databaseDriver
            ->executeSql($sql)
            ->fetchAll();

        if (!$rows) {
            throw new Exception("Ocorreu uma exceção durante a execução da consulta de IMC.", StatusCodeInterface::STATUS_NO_CONTENT);
        }
        foreach ($rows as $row) {
            $classificacao = Util::classificationIMC(floatval($row['imc']));
            $row["classificacao"] = $classificacao;
            $imcs[] = ImcOutputBoundary::build($row);
        }

        return $imcs;
    }

    private function getSQL(string $colun, int $id_user, string $data_avalicao): string
    {
        return "
            select 
                i.imc,
                a.nome as nome_aluno,
                p.nome as nome_personal,
                to_char(i.data, 'DD/MM/YYYY')  as data_avalicao
            from public.imc i
            inner join public.usuario a on a.id = i.id_aluno
            inner join public.usuario p on p.id = i.id_profissional
            where 
                i.$colun = $id_user 
                $data_avalicao 
            order by i.data desc";
    }
}
