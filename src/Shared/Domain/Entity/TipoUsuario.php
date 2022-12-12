<?php

declare(strict_types=1);

namespace App\Shared\Domain\Entity;

use App\Shared\Domain\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * Gravasituacao
 * @ORM\Table(schema="public", name="tipo_usuario")
 * @ORM\Entity
 */
final class TipoUsuario extends Entity
{
    /**
     * @var int
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     */
    protected int $id;

    /**
     * @var string
     * @ORM\Column(name="nome", type="string")
     */
    protected string $nome;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;
        return $this;
    }
}
