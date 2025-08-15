<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'NATIVA FACIL CORRETORA',
            'email' => 'contato@nativafacil.com.br',
            'cnpj_cpf' => '27.244.981/0001-79',
            'tipo_user' => 'Corretora Master',
            'password' => bcrypt('27244981000179'),
        ]);
    }
}
