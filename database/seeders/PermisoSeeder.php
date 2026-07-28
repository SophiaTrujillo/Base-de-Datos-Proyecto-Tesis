<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permisos')->insert([
            [
                'nombre' => 'publicar_noticias',
                'descripcion' => 'Permite publicar noticias',
            ],
            [
                'nombre' => 'gestionar_clubes',
                'descripcion' => 'Permite gestionar clubes',
            ],
            [
                'nombre' => 'ver_calificaciones',
                'descripcion' => 'Permite ver calificaciones',
            ],
            [
                'nombre' => 'usar_chat',
                'descripcion' => 'Permite usar el chat',
            ],
        ]);
    }
}