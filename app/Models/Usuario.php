<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property-read bool $is_admin
 */
class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios'; // Nombre de la tabla

    protected $primaryKey = 'id_usuario'; // Clave primaria

    public $timestamps = true;

    protected $fillable = ['nombre', 'apellido', 'email', 'contraseña', 'telefono', 'foto_perfil', 'rol', 'fecha_registro'];

    // Lista de roles permitidos
    const ROLES = [
        'user',       // Usuario regular
        'admin',      // Técnico
        'superadmin', // Superadministrador
    ];

    // Método para obtener los roles disponibles
    public static function getRoles()
    {
        return self::ROLES;
    }

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

    public function getAuthPassword()
    {
        return $this->contraseña; // Reemplaza 'contraseña' por el nombre exacto del campo en la base de datos
    }

    // Accesor para comprobar si el usuario es admin
    public function getIsAdminAttribute()
    {
        return $this->rol === 'admin';
    }

}
