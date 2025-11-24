<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TallerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                => $this->id,
            'nombre'            => $this->nombre,
            'turno'             => $this->turno,

            // Corrección importante
            'hora_inicio'       => Carbon::parse($this->hora_inicio)->format('H:i'),
            'hora_fin'          => Carbon::parse($this->hora_fin)->format('H:i'),

            'sede'              => $this->sede,

            // Solo fecha, sin zona horaria ni tiempo
            'fecha_inicio'      => Carbon::parse($this->fecha_inicio)->format('Y-m-d'),
            'fecha_fin'         => Carbon::parse($this->fecha_fin)->format('Y-m-d'),

            'capacidad_alumnos' => $this->capacidad_alumnos,
            'descripcion'       => $this->descripcion,
            'requisitos'        => $this->requisitos,
            'temario'           => $this->temario,
            
            // Estado básico hasta implementar inscripciones reales
            'estado'            => $this->estado,
            
            // Información temporal hasta crear las relaciones
            'inscritos_count'   => $this->inscripciones()->where('estado', 'activa')->count(),
            'cupos_disponibles' => $this->cupos_disponibles, // Usará el accessor getCuposDisponiblesAttribute()

            'creacion'          => Carbon::parse($this->created_at)->format('d-m-Y H:i:s A'),
            'actualizacion'     => Carbon::parse($this->updated_at)->format('d-m-Y H:i:s A'),
        ];
    }
}
