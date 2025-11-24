<?php

use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\ConfigAlertController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\ConsultasDni;
use App\Http\Controllers\Api\ConsultasId;
use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\UsuariosController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TallerController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Reportes\AlertPDFController;
use App\Http\Controllers\Reportes\ConfigAlertPDFController;
use App\Http\Controllers\Reportes\SchedulePDFController;
use App\Http\Controllers\Reportes\SpacePDFController;
use App\Http\Controllers\Web\AlertWebController;
use App\Http\Controllers\Web\ConfigAlertWebController;
use App\Http\Controllers\Web\ScheduleWebController;
use App\Http\Controllers\Web\SpaceWebController;
use App\Http\Controllers\Web\TallerWebController;
use App\Http\Controllers\Web\UsuarioWebController;
use App\Http\Controllers\Web\StudentAuthController;
use App\Http\Controllers\Web\StudentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Api\EspacioController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Web\AsistenteWebController;
use App\Http\Controllers\Api\InscripcionController;

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use PSpell\Config;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Ruta pública para guardar mensajes de contacto via WhatsApp
Route::post('/contacto-whatsapp', [ContactController::class, 'store']);

// RUTAS PARA ESTUDIANTES/ALUMNAS
Route::prefix('student')->group(function () {
    // Rutas públicas para estudiantes
    Route::get('/login', [StudentAuthController::class, 'showLoginForm'])->name('student.login');
    Route::post('/login', [StudentAuthController::class, 'login']);
    Route::get('/register', [StudentAuthController::class, 'showRegisterForm'])->name('student.register');
    Route::post('/register', [StudentAuthController::class, 'register']);
    
    // Rutas protegidas para estudiantes autenticados
    Route::middleware(['auth', 'verified'])->group(function () {
        Route::get('/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
        Route::get('/inscripciones', [StudentController::class, 'misInscripciones'])->name('student.inscripciones');
        Route::post('/inscribirse/{taller}', [StudentController::class, 'inscribirse'])->name('student.inscribirse');
        Route::delete('/desinscribirse/{taller}', [StudentController::class, 'desinscribirse'])->name('student.desinscribirse');
    });
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user();
        return Inertia::render('Dashboard', [
            'mustReset' => $user->restablecimiento == 0,
        ]);
    })->name('dashboard');

    #VISTAS DEL FRONTEND
    Route::get('/horarios', [ScheduleWebController::class, 'index']);
    Route::get('/talleres', [TallerWebController::class, 'index']);
    Route::get('/alertas', [AlertWebController::class, 'index']);
    Route::get('/config_alertas', [ConfigAlertWebController::class, 'index']);
    Route::get('/usuario', [UsuarioWebController::class, 'index']);
    Route::get('/roles', [UsuarioWebController::class, 'roles'])->name('roles.view');
    Route::get('/datos/dashboard', [DashboardController::class, 'getdatos']);
    // LISTADO ESPACIOS PARA HORARIOS
    Route::get('/espacio', [EspacioController::class, 'index'])->name('espacio.view');


    // LISTADO EMPLEADOS PARA HORARIOS
   // solo para la vista del módulo empleados (frontend)
    Route::get('/empleado', [EmployeeController::class, 'index'])->name('empleado.view');


    Route::get('/asistente', [AsistenteWebController::class, 'index']);


    // 👇 NUEVO endpoint solo para el Asistente IA
    Route::get('/asistente/talleres-hoy', [AsistenteWebController::class, 'talleresHoy'])
        ->name('asistente.talleres_hoy');

    Route::get('/asistente/alertas-hoy', [AsistenteWebController::class, 'alertasHoy'])
        ->name('asistente.alertas_hoy');

    #CONSULTA  => BACKEND
    Route::get('/consulta/{dni}', [ConsultasDni::class, 'consultar'])->name('consultar.dni');
    Route::get('/user-id', [ConsultasId::class, 'getUserId'])->middleware('auth:api');

    // TALLER -> BACKEND
    Route::prefix('taller')->group(function () {
        Route::get('/', [TallerController::class, 'index'])->name('web.taller.index');

        Route::post('/', [TallerController::class, 'store'])->name('talleres.store');
        Route::get('/{taller}', [TallerController::class, 'show'])->name('talleres.show');
        Route::put('/{taller}', [TallerController::class, 'update'])->name('talleres.update');
        Route::delete('/{taller}', [TallerController::class, 'destroy'])->name('talleres.destroy');
    });

    Route::post('/inscripciones/web', [InscripcionController::class, 'store'])
     ->name('inscripciones.store');

        
    #HORARIO => BACKEND
    Route::prefix('horario')->group(function () {
        Route::get('/', [ScheduleController::class, 'index'])->name('horario.index');
        Route::post('/', [ScheduleController::class, 'store'])->name('horarios.store');
        Route::get('{schedule}', [ScheduleController::class, 'show'])->name('horarios.show');
        Route::put('{schedule}', [ScheduleController::class, 'update'])->name('horarios.update');
        Route::delete('{schedule}', [ScheduleController::class, 'destroy'])->name('horarios.destroy');
    });

    #ALERTA => BACKEND
    Route::prefix('alerta')->group(function () {
        Route::get('/', [AlertController::class, 'index'])->name('alerta.index');
        Route::post('/', [AlertController::class, 'store'])->name('alertas.store');
        Route::get('{alert}', [AlertController::class, 'show'])->name('alertas.show');
        Route::put('{alert}', [AlertController::class, 'update'])->name('alertas.update');
        Route::delete('{alert}', [AlertController::class, 'destroy'])->name('alertas.destroy');
    });

    #CONFIGURACION ALERTA -> BACKEND
    Route::prefix('config_alerta')->group(function () {
        Route::get('/', [ConfigAlertController::class, 'index'])->name('config_alerta.index');
        Route::post('/', [ConfigAlertController::class, 'store'])->name('config_alertas.store');
        Route::get('/latest', [ConfigAlertController::class, 'latest'])->name('config_alertas.latest'); // 👈 nuevo
        Route::get('/{configAlert}', [ConfigAlertController::class, 'show'])->name('config_alertas.show');
        Route::put('/{configAlert}', [ConfigAlertController::class, 'update'])->name('config_alertas.update');
        Route::delete('/{configAlert}', [ConfigAlertController::class, 'destroy'])->name('config_alertas.destroy');
    });

    #USUARIOS -> BACKEND
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UsuariosController::class, 'index'])->name('usuarios.index');
        Route::post('/', [UsuariosController::class, 'store'])->name('usuarios.store');
        Route::get('/{user}', [UsuariosController::class, 'show'])->name('usuarios.show');
        Route::put('/{user}', [UsuariosController::class, 'update'])->name('usuarios.update');
        Route::delete('/{user}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy');
    });

    #ROLES => BACKEND
    Route::prefix('rol')->group(function () {
        Route::get('/', [RolesController::class, 'index'])->name('rol.index');
        Route::get('/Permisos', [RolesController::class, 'indexPermisos'])->name('rol.indexPermisos');
        Route::post('/', [RolesController::class, 'store'])->name('rol.store');
        Route::get('/{id}', [RolesController::class, 'show'])->name('rol.show');
        Route::put('/{id}', [RolesController::class, 'update'])->name('rol.update');
        Route::delete('/{id}', [RolesController::class, 'destroy'])->name('rol.destroy');
    });

    Route::prefix('panel/reports')->group(function () {

        #EXPORTACION Y IMPORTACION ESPACIOS
        Route::get('/export-excel-spaces', [SpaceWebController::class, 'exportExcel']);

        Route::get('/export-pdf-spaces', [SpacePDFController::class, 'exportPDF'])->name('export-pdf-spaces');
        // Ruta para importar desde Excel
        //Route::post('/import-excel-spaces', [SpaceController::class, 'importExcel'])->name('import-excel-spaces');

        #EXPORTACION Y IMPORTACION HORARIOS
        Route::get('/export-excel-schedules', [ScheduleController::class, 'exportExcel'])->name('export-excel-schedules');
        Route::get('/export-pdf-schedules', [SchedulePDFController::class, 'exportPDF'])->name('export-pdf-schedules');
        // Ruta para importar desde Excel
        //Route::post('/import-excel-schedules', [ScheduleController::class, 'importExcel'])->name('import-excel-schedules');

        #EXPORTACION Y IMPORTACION ALERTAS
        Route::get('/export-excel-alerts', [AlertController::class, 'exportExcel'])->name('export-excel-alerts');
        Route::get('/export-pdf-alerts', [AlertPDFController::class, 'exportPDF'])->name('export-pdf-alerts');
        // Ruta para importar desde Excel
        //Route::post('/import-excel-alerts', [AlertController::class, 'importExcel'])->name('import-excel-alerts');

        #EXPORTACION Y IMPORTACION CONFIGURACION DE ALERTAS
        Route::get('/export-excel-config_alerts', [ConfigAlertController::class, 'exportExcel'])->name('export-excel-config_alerts');
        Route::get('/export-pdf-config_alerts', [ConfigAlertPDFController::class, 'exportPDF'])->name('export-pdf-config_alerts');
        // Ruta para importar desde Excel
        //Route::post('/import-excel-config_alerts', [AlertController::class, 'importExcel'])->name('import-excel-config_alerts');
    });
});

//RUTAS PARA ADMINISTRADORES
Route::get('/register', [RegisteredUserController::class, 'create'])
    ->middleware('guest')
    ->name('register');

Route::post('/register', [RegisteredUserController::class, 'store'])
    ->middleware('guest');

// Archivos de configuración adicionales
require __DIR__ . '/settings.php';
require __DIR__ . '/auth.php';
