<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $table = 'usuarios'; // Nombre de la tabla

    protected $primaryKey = 'id_usuario'; // Clave primaria

    public $timestamps = true;

    protected $fillable = ['nombre', 'email', 'contraseña', 'telefono', 'foto_perfil', 'rol', 'fecha_registro'];

    // Relación con incidencias (1 usuario tiene muchas incidencias)
    public function incidencias()
    {
        return $this->hasMany(Incidencia::class, 'usuario_id', 'id_usuario');
    }

    // Relación con comentarios (1 usuario tiene muchos comentarios)
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'usuario_id', 'id_usuario');
    }
}
