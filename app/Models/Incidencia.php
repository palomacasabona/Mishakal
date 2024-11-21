<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    protected $table = 'incidencias';

    protected $primaryKey = 'id_incidencia';

    public $timestamps = true;

    protected $fillable = ['titulo', 'descripcion', 'estado', 'categoria', 'prioridad', 'fecha_creacion', 'usuario_id'];

    // Relación con usuario (1 incidencia pertenece a 1 usuario)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    // Relación con comentarios (1 incidencia tiene muchos comentarios)
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'incidencia_id', 'id_incidencia');
    }
}
