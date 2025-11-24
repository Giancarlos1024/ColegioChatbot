<?php

use App\Http\Controllers\Api\AlertController;
use App\Http\Controllers\Api\ConfigAlertController;
use App\Http\Controllers\Api\EmployeeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EmployeeTypeController;
use App\Http\Controllers\Api\MovementController;
use App\Http\Controllers\Api\ScheduleController;
use App\Http\Controllers\Api\TallerController;
use App\Http\Controllers\Api\EspacioController;   // 👈 AÑADIR ESTA
use App\Http\Controllers\Reportes\EmployeeTypePDFController;
use App\Http\Controllers\Reportes\EmployeePDFController;
use App\Http\Controllers\Reportes\SchedulePDFController;
use App\Http\Controllers\Reportes\SpacePDFController;
use App\Http\Controllers\Reportes\TallerPDFController;
use App\Http\Controllers\Api\VerificarAccesoController;
use App\Http\Controllers\Api\InscripcionController;
use App\Models\EmployeeType;
Route::post(uri: '/verificar-acceso', action: [VerificarAccesoController::class, 'verificar']);
Route::get('/verificar-acceso', function () {
    return response()->json(['mensaje' => 'Ruta funcionando, usa POST para enviar datos.']);
});
Route::middleware('auth')->group(function () {
     Route::apiResource('tipos_empleados', EmployeeTypeController::class)
        ->names('api.tipos_empleados');

    Route::apiResource('empleado', EmployeeController::class)
        ->names('api.empleado');

    Route::apiResource('espacio', EspacioController::class)
        ->names('api.espacio');

    Route::apiResource('config_alertas', ConfigAlertController::class)
        ->names('api.config_alertas');

    Route::apiResource('movimiento', MovementController::class)
        ->names('api.movimiento');

    Route::apiResource('alerta', AlertController::class)
        ->names('api.alerta');

    Route::apiResource('horario', ScheduleController::class)
        ->names('api.horario');  
    Route::apiResource('taller', TallerController::class)
        ->names('api.taller');
    
    //Route::apiResource('caja', CajaController::class);

    #EXPORT API
    // Exportación a Excel
    Route::get('/talleres/export-excel', [TallerController::class, 'exportExcel']);
    Route::get('/horarios/export-excel', [ScheduleController::class, 'exportExcel']);
    Route::get('/tipos_empleados/export-excel', [EmployeeTypeController::class, 'exportExcel']);
    Route::get('/empleados/export-excel', [EmployeeController::class, 'exportExcel']);
    //Route::get('/movimientos/export-excel', [MovementController::class, 'exportExcel']);
    Route::get('/alertas/export-excel', [AlertController::class, 'exportExcel']);
    
    // Exportación a PDF
    Route::get('/talleres/export-pdf', [TallerPDFController::class, 'exportPDF']);

    Route::get('/horarios/export-pdf', [SchedulePDFController::class, 'exportPDF']);
    Route::get('/tipos_empleados/export-pdf', [EmployeeTypePDFController::class, 'exportPDF']);
    Route::get('/empleados/export-pdf', [EmployeePDFController::class, 'exportPDF']);
    //Route::get('/movimientos/export-pdf', [MovementPDFController::class, 'exportPDF']);
    //Route::get('/alertas/export-pdf', [AlertPDFController::class, 'exportPDF']);

    #IMPORT API
    // Importación de Excel
    Route::post('/talleres/import-excel', [TallerController::class, 'importExcel']);
    Route::post('/horarios/import-excel', [ScheduleController::class, 'importExcel']);
    Route::post('/tipos_empleados/import-excel', [EmployeeTypeController::class, 'importExcel']);
    Route::post('/empleados/import-excel', [EmployeeController::class, 'importExcel']);
    // 👉 NUEVA RUTA DE INSCRIPCIÓN
   // 👉 NUEVA RUTA DE INSCRIPCIÓN
    Route::post('/inscripciones', [InscripcionController::class, 'store'])
        ->name('api.inscripciones.store');
    //Route::post('/movimientos/import-excel', [MovementController::class, 'importExcel']);
});

