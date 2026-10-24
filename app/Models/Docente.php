<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    protected $connection = 'mysql_docente';

    protected $table = 'docentes';

    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'especialidad',
        'correo',
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionDocente::class, 'docente_id');
    }
}
