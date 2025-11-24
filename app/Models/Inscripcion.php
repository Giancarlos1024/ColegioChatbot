<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'taller_id',
        'user_id',
        'fecha_inscripcion',
        'estado',
        'notas',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'datetime',
    ];

    // Relación con Taller
    public function taller()
    {
        return $this->belongsTo(Taller::class, 'taller_id');
    }

    // Relación con Usuario
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Scopes útiles
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activa');
    }

    public function scopePorTaller($query, $tallerId)
    {
        return $query->where('taller_id', $tallerId);
    }
}
