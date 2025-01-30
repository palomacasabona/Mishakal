<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incidencia extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'incidencias';

    // Nombre de la clave primaria
    protected $primaryKey = 'id_incidencia';

    // Si no tienes columnas de timestamps (created_at y updated_at)
    public $timestamps = false;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'titulo',
        'descripcion',
        'categoria',
        'prioridad',
        'estado',
        'usuario_id',
        'archivo',
        'asignado_a', // Agregar este campo al array de $fillable
    ];
    /**
     * Relación: una incidencia pertenece a un usuario.
     */
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'usuario_id', 'id_usuario');
    }

    /**
     * Relación: una incidencia puede tener un único archivo.
     */
    public function archivo()
    {
        return $this->hasOne(Archivo::class, 'incidencia_id', 'id_incidencia');
    }

    /**
     * Relación: una incidencia puede tener múltiples comentarios.
     */
    public function comentarios()
    {
        return $this->hasMany(Comentario::class, 'incidencia_id', 'id_incidencia');
    }

    public function mensajes()
    {
        return $this->hasMany(Mensaje::class, 'incidencia_id', 'id_incidencia');
    }
}
