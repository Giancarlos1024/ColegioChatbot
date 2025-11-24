<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Taller;
use App\Models\Schedule;
use App\Models\Alert;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getdatos(Request $request)
    {
        // Obtener las fechas de inicio y fin desde los parámetros de la solicitud
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Estadísticas del sistema
        $totalUsuarios = User::count();
        $totalTalleres = Taller::count();
        $totalAlertas = Alert::count();
        $totalHorarios = Schedule::count();

        // Filtros de fecha
        $queryTalleres = Taller::query();
        $queryAlertas = Alert::query();
        $queryHorarios = Schedule::query();
        $queryUsuarios = User::query();

        if ($startDate) {
            $startDate = Carbon::parse($startDate)->startOfDay();
            $queryTalleres->where('created_at', '>=', $startDate);
            $queryAlertas->where('created_at', '>=', $startDate);
            $queryHorarios->where('created_at', '>=', $startDate);
            $queryUsuarios->where('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $endDate = Carbon::parse($endDate)->endOfDay();
            $queryTalleres->where('created_at', '<=', $endDate);
            $queryAlertas->where('created_at', '<=', $endDate);
            $queryHorarios->where('created_at', '<=', $endDate);
            $queryUsuarios->where('created_at', '<=', $endDate);
        }

        // Datos para el dashboard
        $stats = [
            'totalUsers' => $totalUsuarios,
            'totalTalleres' => $totalTalleres,
            'totalAlerts' => $totalAlertas,
            'totalSchedules' => $totalHorarios,
        ];

        // Retornar tanto las estadísticas como la información del usuario
        return response()->json([
            'stats' => $stats,
            'user' => $user
        ]);
    }
}
