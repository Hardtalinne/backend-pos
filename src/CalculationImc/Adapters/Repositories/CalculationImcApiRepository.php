<?php

namespace App\CalculationImc\Adapters\Repositories;

use App\CalculationImc\UseCases\Contracts\CalculationImcRepositoryInterface;
use App\Shared\Adapters\Contracts\QueryBuilder\InsertStatement;
use App\Shared\Adapters\Contracts\QueryBuilder\SelectStatement;
use Exception;
use Fig\Http\Message\StatusCodeInterface;

final class CalculationImcApiRepository implements CalculationImcRepositoryInterface
{
    private SelectStatement $selectStatement;
    private InsertStatement $insertStatement;

    public function __construct(
        SelectStatement $selectStatement,
        InsertStatement $insertStatement
    ) {
        $this->selectStatement = $selectStatement;
        $this->insertStatement = $insertStatement;
    }

    public function saveIMC(float $imc, int $id_student, int $id_professional): bool
    {
        try {
            $values = [
                'imc' => $imc,
                'id_aluno' => $id_student,
                'id_profissional' =>  $id_professional
            ];

            $this->insertStatement
                ->into("public.imc")
                ->values($values)
                ->insert();
            return true;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante ao salvar o IMC.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
    public function FindStudent(int $id_student): array
    {
        try {
            $row = $this->selectStatement
                ->select(['nome'])
                ->from("public.usuario")
                ->where("id", $id_student)
                ->fetchOne();
            if (!$row) {
                throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
            }
            return $row;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
    public function FindProfessional(int $id_professional): array
    {
        try {
            $row = $this->selectStatement
                ->select(['nome'])
                ->from("public.usuario")
                ->where("id", $id_professional)
                ->fetchOne();
            if (!$row) {
                throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
            }
            return $row;
        } catch (Exception $exception) {
            throw new Exception("Ocorreu uma exceção durante a execução da busca pelo usuário.", StatusCodeInterface::STATUS_INTERNAL_SERVER_ERROR);
        }
    }
}
