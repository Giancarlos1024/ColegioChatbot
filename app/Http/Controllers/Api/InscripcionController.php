<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inscripcion;
use App\Models\Taller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InscripcionController extends Controller
{
    public function store(Request $request)
    {
        // Usuario autenticado
        $user = Auth::user();

        if (!$user) {
            return response()->json([
                'state'   => false,
                'message' => 'Usuario no autenticado.',
            ], 401);
        }

        // Validar datos
        $request->validate([
            'taller_id' => 'required|exists:taller,id',
        ]);

        $taller = Taller::findOrFail($request->taller_id);

        // 1) Verificar si ya está inscrito en ese taller
        $existe = Inscripcion::where('user_id', $user->id)
            ->where('taller_id', $taller->id)
            ->where('estado', 'activa')
            ->exists();

        if ($existe) {
            return response()->json([
                'state'   => false,
                'message' => 'Ya estás inscrito en este taller.',
            ], 400);
        }

        // 2) Verificar cupos
        $inscritosActivos = Inscripcion::where('taller_id', $taller->id)
            ->where('estado', 'activa')
            ->count();

        if ($inscritosActivos >= $taller->capacidad_alumnos) {
            return response()->json([
                'state'   => false,
                'message' => 'El taller ya no tiene cupos disponibles.',
            ], 400);
        }

        // 3) Crear inscripción
        $inscripcion = Inscripcion::create([
            'taller_id'        => $taller->id,
            'user_id'          => $user->id,
            'fecha_inscripcion'=> now(),
            'estado'           => 'activa',
            'notas'            => null,
        ]);

        return response()->json([
            'state'       => true,
            'message'     => 'Inscripción realizada correctamente.',
            'inscripcion' => $inscripcion,
        ]);
    }
}
