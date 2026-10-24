<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    protected $connection = 'mysql';

    protected $table = 'estudiantes';

    public $timestamps = false;

    protected $fillable = [
        'nombres',
        'apellidos',
        'correo',
        'fecha_nacimiento',
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'estudiante_id');
    }
}
