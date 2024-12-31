<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'archivos';

    // Nombre de la clave primaria
    protected $primaryKey = 'id_archivo';

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'nombre',
        'ruta_archivo',
        'incidencia_id', // Relación con la incidencia
    ];

    /**
     * Relación: un archivo pertenece a una incidencia.
     */
    public function incidencia()
    {
        return $this->belongsTo(Incidencia::class, 'incidencia_id', 'id_incidencia');
    }

    /**
     * Devuelve la URL pública del archivo.
     * Se usa para generar el enlace o mostrar la miniatura.
     */
    public function getRutaPublicaAttribute()
    {
        return asset('storage/' . $this->ruta_archivo);
    }
}
