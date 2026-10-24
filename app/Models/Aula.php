<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    protected $connection = 'mysql_docente';

    protected $table = 'aulas';

    public $timestamps = false;

    protected $fillable = [
        'codigo',
        'capacidad',
        'ubicacion',
    ];

    public function asignaciones()
    {
        return $this->hasMany(AsignacionDocente::class, 'aula_id');
    }
}
