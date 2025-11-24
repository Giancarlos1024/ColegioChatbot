<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// 👇 IMPORTA Inscripcion
use App\Models\Inscripcion;

class Taller extends Model
{
    use HasFactory;

    protected $table = 'taller';

    protected $fillable = [
        'nombre',
        'turno',
        'hora_inicio',
        'hora_fin',
        'sede',
        'fecha_inicio',
        'fecha_fin',
        'capacidad_alumnos',
        'descripcion',
        'requisitos',
        'temario',
    ];

    protected $casts = [
        'fecha_inicio'      => 'date',
        'fecha_fin'         => 'date',
        'hora_inicio'       => 'string',
        'hora_fin'          => 'string',
        'capacidad_alumnos' => 'integer',
        'estado'            => 'string',
    ];

    // 🔹 Relación con inscripciones (ACTÍVALA)
    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class, 'taller_id');
    }

    // 🔹 Estado real según cupos
    public function getEstadoAttribute()
    {
        return $this->cupos_disponibles <= 0 ? 'lleno' : 'disponible';
    }

    // 🔹 Cupos disponibles reales = capacidad - inscripciones activas
    public function getCuposDisponiblesAttribute()
    {
        $inscritosActivos = $this->inscripciones()
            ->where('estado', 'activa')
            ->count();

        return max(0, $this->capacidad_alumnos - $inscritosActivos);
    }
}
