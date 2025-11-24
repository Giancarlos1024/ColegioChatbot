<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Taller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class StudentController extends Controller
{
    /**
     * Dashboard principal del estudiante
     */
    public function dashboard()
    {
        $user = Auth::user();
        
        // Verificar que sea estudiante
        if ($user->role !== 'estudiante') {
            abort(403, 'Acceso no autorizado');
        }

        // Obtener talleres disponibles para inscribirse
        $talleresDisponibles = Taller::all();
        
        // Obtener talleres en los que está inscrita
        $misTalleres = $user->talleres ?? collect();

        return Inertia::render('student/Dashboard', [
            'user' => $user,
            'talleresDisponibles' => $talleresDisponibles,
            'misTalleres' => $misTalleres,
        ]);
    }

    /**
     * Ver inscripciones del estudiante
     */
    public function misInscripciones()
    {
        $user = Auth::user();
        
        if ($user->role !== 'estudiante') {
            abort(403, 'Acceso no autorizado');
        }

        $misInscripciones = $user->talleres ?? collect();

        return Inertia::render('student/Inscripciones', [
            'inscripciones' => $misInscripciones,
        ]);
    }

    /**
     * Inscribirse a un taller
     */
    public function inscribirse(Request $request, Taller $taller)
    {
        $user = Auth::user();
        
        if ($user->role !== 'estudiante') {
            abort(403, 'Acceso no autorizado');
        }

        // Verificar si ya está inscrita
        if ($user->talleres()->where('taller_id', $taller->id)->exists()) {
            return back()->with('error', 'Ya estás inscrita en este taller.');
        }

        // Verificar si el taller tiene cupos disponibles
        if ($taller->estado === 'lleno') {
            return back()->with('error', 'Este taller ya está lleno.');
        }

        // Crear la inscripción
        $user->talleres()->attach($taller->id, [
            'fecha_inscripcion' => now(),
            'estado' => 'activa'
        ]);

        return back()->with('success', '¡Te has inscrito exitosamente en el taller!');
    }

    /**
     * Desinscribirse de un taller
     */
    public function desinscribirse(Request $request, Taller $taller)
    {
        $user = Auth::user();
        
        if ($user->role !== 'estudiante') {
            abort(403, 'Acceso no autorizado');
        }

        // Verificar si está inscrita
        if (!$user->talleres()->where('taller_id', $taller->id)->exists()) {
            return back()->with('error', 'No estás inscrita en este taller.');
        }

        // Eliminar la inscripción
        $user->talleres()->detach($taller->id);

        return back()->with('success', 'Te has desinscrito del taller exitosamente.');
    }
}
