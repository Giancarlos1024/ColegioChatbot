<?php
namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\TallerResource;
use App\Http\Resources\AlertResource;
use App\Models\Taller;
use App\Models\Alert;
use Carbon\Carbon;
use Inertia\Inertia;

class AsistenteWebController extends Controller
{
    public function index()
    {
        return Inertia::render('panel/Asistente/indexAsistent');
    }

    public function talleresHoy()
    {
        $hoy = Carbon::today()->toDateString();

        $talleres = Taller::whereDate('fecha_inicio', '<=', $hoy)
            ->whereDate('fecha_fin', '>=', $hoy)
            ->get();

        return TallerResource::collection($talleres);
    }

    public function alertasHoy()
    {
        $hoy = Carbon::today()->toDateString();

        $alertas = Alert::whereDate('fecha', $hoy)->get();

        return AlertResource::collection($alertas);
    }
}
