<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asignatura extends Model
{
    protected $connection = 'mysql';

    protected $table = 'asignaturas';

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'codigo',
        'creditos',
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'asignatura_id');
    }
}
