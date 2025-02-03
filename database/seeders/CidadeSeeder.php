<?php

namespace Database\Seeders;

use App\Models\Cidade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CidadeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cidade::factory()->count(10)->create();
        Cidade::query()->updateOrCreate(['nome' => 'São Paulo', 'estado' => 'SP']);
        Cidade::query()->updateOrCreate(['nome' => 'Rio de Janeiro', 'estado' => 'RJ']);
    }
}
