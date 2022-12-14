<?php


use Phinx\Seed\AbstractSeed;

class UsuarioSeeder extends AbstractSeed
{
    public function run()
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $data = [
            [
                'nome' => 'Renan',
                'usuario' => 'renan',
                'senha' => '$2y$10$aqqaG\/mKqqXl7fQiU3.0gekfKcdaqsKdJQ3gvJPOyb344BvN4yKUe',
                'tipo_usuario' => 2
            ],
            [
                'nome' => 'Aline',
                'usuario' => 'aline',
                'senha' => '$2y$10$aqqaG\/mKqqXl7fQiU3.0gekfKcdaqsKdJQ3gvJPOyb344BvN4yKUe',
                'tipo_usuario' => 1
            ],
        ];

        $usuarios = $this->table('usuario');
        $usuarios->insert($data)
            ->saveData();
    }
}
