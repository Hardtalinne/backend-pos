<?php


use Phinx\Seed\AbstractSeed;

class TipoUsuarioSeeder extends AbstractSeed
{
    public function run()
    {
        $data = [
            [
                'nome' => 'Admin'
            ],
            [
                'nome' => 'Profissional',
            ],
            [
                'nome' => 'Aluno',
            ],
        ];

        $usuarios = $this->table('tipo_usuario');
        $usuarios->insert($data)
            ->saveData();
    }
}
