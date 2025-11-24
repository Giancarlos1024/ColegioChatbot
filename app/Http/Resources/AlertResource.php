<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'id'            => $this->id,
            'titulo'        => $this->titulo,
            'descripcion'   => $this->descripcion,
            // la columna es DATE, la formateamos a 'Y-m-d'
            'fecha'         => optional($this->fecha)->format('Y-m-d'),

            // para la tabla
            'creacion'      => optional($this->created_at)->format('Y-m-d H:i:s'),
            'actualizacion' => optional($this->updated_at)->format('Y-m-d H:i:s'),

            // 🔹 Compatibilidad con el front antiguo (ListAlerta.vue)
            //    así no revienta aunque ya no uses movimientos
            'idMovimientos' => [],        // antes era array de IDs
            'movimientos'   => [],        // antes era listado detallado
        ];
    }
}
