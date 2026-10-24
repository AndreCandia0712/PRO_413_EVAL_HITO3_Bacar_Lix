<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionAcademica extends Model
{
    protected $connection = 'mysql_docente';

    protected $table = 'gestiones_academicas';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'fecha_inicio',
        'fecha_fin',
    ];

    public function asignaciones()
    {
        return $this->hasMany(
            AsignacionDocente::class,
            'gestion_academica_id'
        );
    }
}
