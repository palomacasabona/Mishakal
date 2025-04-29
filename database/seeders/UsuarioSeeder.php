<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;

class UsuarioSeeder extends Seeder
{
    public function run()
    {
        // Crear 200 usuarios nuevos con fotos aleatorias
        //Usuario::factory()->count(802)->create();
        for ($i = 1; $i <= 200; $i++) {
            $usuario = Usuario::find($i);
            if ($usuario && empty($usuario->foto_perfil)) {
                $number = rand(1, 70);
                $usuario->foto_perfil = "https://i.pravatar.cc/150?img={$number}";
                $usuario->save();
            }
        }

        // Ahora actualizamos SOLO los usuarios que no tienen foto
        //Usuario::whereNull('foto_perfil')->orWhere('foto_perfil', '')->get()->each(function ($usuario) {
            //$number = rand(1, 70);
            //$usuario->foto_perfil = "https://i.pravatar.cc/150?img={$number}";
            //$usuario->save();
        //});
    }

}
