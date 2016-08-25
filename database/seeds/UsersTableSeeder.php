<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\User::create([
            'name' => 'Felipe Bergamin',
            'email' => 'felipebergamin6@gmail.com',
            'password' => bcrypt('fe.li.pe.'),
            'habilitado' => 1
        ]);

        $user->permissoes()->create([
            'enviar_sms' => true,
            'enviar_lote_sms' => true,
            'visualizar_envios' => true,
            'visualizar_relatorios' => true,
            'manter_usuarios' => true
        ]);
    }
}
