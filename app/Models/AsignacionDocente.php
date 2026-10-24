<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AsignacionDocente extends Model
{
    protected $connection = 'mysql_docente';

    protected $table = 'asignaciones_docentes';

    public $timestamps = false;

    protected $fillable = [
        'docente_id',
        'gestion_academica_id',
        'aula_id',
        'asignatura_id',
    ];

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'docente_id');
    }

    public function gestionAcademica()
    {
        return $this->belongsTo(
            GestionAcademica::class,
            'gestion_academica_id'
        );
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'aula_id');
    }
}
