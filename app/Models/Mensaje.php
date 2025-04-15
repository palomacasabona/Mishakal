<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
    ];

    // Relación con la incidencia
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id', 'id_incidencia');
    }

    // Relación con el remitente (usuario)
    public function remitente()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario'); // Ajustar clave foránea
    }

    // Relación con el destinatario (usuario)
    public function destinatario()
    {
        return $this->belongsTo(Usuario::class, 'destinatario_id', 'id');
    }
}
