<?php


use Phinx\Seed\AbstractSeed;

class UsuarioSeeder extends AbstractSeed
{
    public function run()
    {
        $now = (new DateTimeImmutable())->format('Y-m-d H:i:s');

        $data = [
            [
                'nome' => 'Renan Personal',
                'usuario' => 'renan.personal',
                'senha' => '$2y$10$aqqaG/mKqqXl7fQiU3.0gekfKcdaqsKdJQ3gvJPOyb344BvN4yKUe',
                'status' => 1,
                'tipo_usuario' => 2
            ],
            [
                'nome' => 'Aline Aluna',
                'usuario' => 'aline.aluna',
                'senha' => '$2y$10$aqqaG/mKqqXl7fQiU3.0gekfKcdaqsKdJQ3gvJPOyb344BvN4yKUe',
                'status' => 1,
                'tipo_usuario' => 1
            ],
        ];

        $usuarios = $this->table('usuario');
        $usuarios->insert($data)
            ->saveData();
    }
}
