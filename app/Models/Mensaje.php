<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;


class Mensaje extends Model
{
    use HasFactory;

    // Tabla asociada
    protected $table = 'mensajes';

    // Campos rellenables
    protected $fillable = [
        'contenido',
        'incidencia_id',
        'remitente_id',
        'destinatario_id',
        'fecha_envio',
        'mensaje_id', // 👈 añadido
        'notificado' => 'boolean', // para las notis

    ];

    // Relación con la incidencia
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id', 'id_incidencia');
    }

    // Relación con el remitente (usuario que envía el mensaje)
    public function remitente()
    {
        return $this->belongsTo(Usuario::class, 'remitente_id', 'id_usuario');    }
    // Relación con el destinatario (usuario que recibe el mensaje)
    public function destinatario()
    {
        return $this->belongsTo(Usuario::class, 'destinatario_id', 'id_usuario');
    }

    // Relación: este mensaje puede tener respuestas
    // Relaciones de hilo
    public function respuestas()
    {
        return $this->hasMany(Mensaje::class, 'mensaje_id', 'id_mensaje');
    }

    public function padre()
    {
        return $this->belongsTo(Mensaje::class, 'mensaje_id', 'id_mensaje');
    }
}
