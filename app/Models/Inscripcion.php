<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $connection = 'mysql';

    protected $table = 'inscripciones';

    public $timestamps = false;

    protected $fillable = [
        'estudiante_id',
        'asignatura_id',
        'fecha_inscripcion',
        'estado',
    ];

    public function estudiante()
    {
        return $this->belongsTo(Estudiante::class, 'estudiante_id');
    }

    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    public function calificaciones()
    {
        return $this->hasMany(Calificacion::class, 'inscripcion_id');
    }
}
