<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class Usuario extends AbstractMigration
{
    public function change(): void
    {
        $players = $this->table('usuario');

        $players->addColumn('nome', 'string', ['limit' => 60])
            ->addColumn('usuario', 'string', ['limit' => 14])
            ->addColumn('senha', 'string', ['limit' => 100])
            ->addColumn('status', 'integer')
            ->addColumn('tipo_usuario', 'integer')
            ->addColumn('email', 'string', ['limit' => 100, 'null' => true])
            ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addForeignKey('tipo_usuario', 'public.tipo_usuario')
            ->create();
    }
}
