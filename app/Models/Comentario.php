<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $table = 'comentarios';

    protected $primaryKey = 'id_comentario';

    public $timestamps = true;

    protected $fillable = ['contenido', 'fecha_comentario', 'usuario_id', 'incidencia_id'];

    // Relación con usuario (1 comentario pertenece a 1 usuario)
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    // Relación con incidencia (1 comentario pertenece a 1 incidencia)
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id', 'id_incidencia');
    }
}
