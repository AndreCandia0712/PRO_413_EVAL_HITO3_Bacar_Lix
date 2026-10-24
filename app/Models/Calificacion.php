<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    protected $connection = 'mysql';

    protected $table = 'calificaciones';

    public $timestamps = false;

    protected $fillable = [
        'inscripcion_id',
        'nota',
        'observacion',
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class, 'inscripcion_id');
    }
}
