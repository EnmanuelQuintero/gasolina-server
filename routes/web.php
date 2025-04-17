<?php
use Illuminate\Support\Facades\Route;
//Controlador de usuario 
use App\Http\Controllers\Auth\AuthController;
//controladores de catalogo
use App\Http\Controllers\Catalogos\CargosController;
use App\Http\Controllers\Catalogos\CatalogoAreaController;
use App\Http\Controllers\Catalogos\CatalogoCombustiblesController;
use App\Http\Controllers\Catalogos\CatalogoGasolinerasController;
use App\Http\Controllers\Catalogos\CatalogoVehiculosController;
use App\Http\Controllers\Catalogos\MarcasVehiculosController;
use App\Http\Controllers\Catalogos\ModelosVehiculosController;
use App\Http\Controllers\Catalogos\PersonaController;
//controlador de orden
use App\Http\Controllers\QRController;
use App\Http\Controllers\Orden\OrdenController;

//controlador prueba
use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\GraficoController;
use App\Http\Controllers\Informes\InformeController;
use Illuminate\Support\Facades\Auth;


//controlador para usuarios
use App\Http\Controllers\UserController;
use App\Models\Orden;
use App\Models\Persona;

//Rutas de Login y usuarios
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

//Rutas Recursos Catalogos
Route::group(['middleware' => ['role:admin']], function () {
    Route::resource('cargos', CargosController::class);
    Route::resource('catalogo-gasolineras', CatalogoGasolinerasController::class);
    Route::resource('catalogo-vehiculos', CatalogoVehiculosController::class);
    Route::resource('marcas-vehiculos', MarcasVehiculosController::class);
    Route::resource('modelos-vehiculos', ModelosVehiculosController::class);
    Route::resource('catalogo-departamento', CatalogoAreaController::class);
    Route::resource('catalogo-combustibles', CatalogoCombustiblesController::class);
    // Rutas de recurso para personas
    Route::resource('personas', PersonaController::class);
    Route::get('/catalogo-vehiculos/{id}', [CatalogoVehiculosController::class, 'show']);
    Route::post('/vehiculos/{id}/toggle-activo', [CatalogoVehiculosController::class, 'toggleActivo']);
    Route::post('/personas/{id}/toggle-activo', [PersonaController::class, 'toggleActivo']);
})->middleware('auth');;
Route::get('/grafico-ordenes', [GraficoController::class, 'obtenerDatosGrafico']);
//Rutas de la orden
Route::group(['middleware' => ['role:admin|operador']], function () {
    

    //Manejo de ordenes
    Route::resource('orden', OrdenController::class);
    Route::get('/entregar/orden/{id}',[OrdenController::class,'entregar'])->name('entrega');
    Route::put('/detalles/entregados', [OrdenController::class, 'cambiar_entregado'])->name('entregar.orden');
    Route::get('/orden', [OrdenController::class, 'index'])->name('orden.index');
    Route::get('/orden/{id}', [OrdenController::class, 'show']);
    Route::get('/ordenes/{orden}/detalles', [OrdenController::class, 'mostrarDetalles'])->name('ordenes.detalles');


    Route::post('/entregar-multiple', [OrdenController::class, 'entregarMultiples'])->name('entrega.multiple');


    //Pantalla Principal
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard.index');



    
    
    //Rutas Reportes

    Route::get('/consolidado/{startDate}/{endDate}',[AdminController::class,'verConsolidado'])->name('consolidado.ver');
    Route::get('/pdf/consolidado/{startDate}/{endDate}', [InformeController::class, 'generarReporte'])->name('report.pdf');
    Route::get('/excel/consolidado/{startDate}/{endDate}', [InformeController::class, 'generarExcel'])->name('report.excel');


    Route::get('/pdf/solicitadas/{startDate}/{endDate}',[InformeController::class,'generarReporteSolicitadas'])->name('report.solicitadas.pdf');
    Route::get('/pdf/entregadas/{startDate}/{endDate}',[InformeController::class,'generarReporteEntregadas'])->name('report.entregadas.pdf');

    Route::get('/excel/solicitadas/{startDate}/{endDate}',[InformeController::class,'generarExcelSolicitadas'])->name('report.solicitadas.excel');
    Route::get('/excel/entregadas/{startDate}/{endDate}',[InformeController::class,'generarExcelEntregadas'])->name('report.entregadas.excel');


    Route::get('/ver/solicitadas/{startDate}/{endDate}',[InformeController::class,'verReporteSolicitadas'])->name('ver.solicitadas.pdf');
    Route::get('/ver/entregadas/{startDate}/{endDate}',[InformeController::class,'verReporteEntregadas'])->name('ver.entregadas.pdf');

});




//Rutas de actualizacion de estado activo o no activo
Route::group(['middleware' => ['role:admin']], function () {
    Route::post('/catalogo-gasolineras/{id}/estado', [CatalogoGasolinerasController::class, 'estado'])->name('catalogo-gasolineras.estado');
    Route::post('/catalogo-combustibles/{id}/estado', [CatalogoCombustiblesController::class, 'estado'])->name('catalogo-combustibles.estado');
    Route::post('/cargos/{id}/estado', [CargosController::class, 'estado'])->name('cargos.estado');
    Route::post('/marcas-vehiculos/{id}/estado', [MarcasVehiculosController::class, 'estado'])->name('marcas-vehiculos.estado');
    Route::post('/personas/{id}/estado', [PersonaController::class, 'estado'])->name('personas.estado');
    Route::post('/modelos-vehiculos/{id}/estado', [ModelosVehiculosController::class, 'estado'])->name('modelos-vehiculos.estado');
    Route::post('/catalogo-areas/{id}/estado', [CatalogoAreaController::class, 'estado'])->name('catalogo-areas.estado');
    Route::post('/orden/{id}/estado', [OrdenController::class, 'estado'])->name('orden.estado');
    Route::post('/catalogo-vehiculos/{id}/estado', [CatalogoVehiculosController::class, 'estado'])->name('catalogo-vehiculos.estado');

});

//Ruta para obtener codigo Qr
Route::get('/qrcode', [QrController::class, 'generate']);



Route::group(['middleware' => ['role:admin']], function () {
    //Rutas vehiculos
    Route::put('/catalogo-vehiculos/{id}', [CatalogoVehiculosController::class, 'update']);

    //Rutas persona
    Route::get('personas', [PersonaController::class, 'index'])->name('personas.index');

    //Rutas para usuarios
    Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
    Route::post('/users', [UserController::class, 'store'])->name('users.store');
    Route::get('/users/ver', [UserController::class, 'index'])->name('users.index');

    //Rutas de prueba 
    Route::get('superadmin/dashboard', function() {
        return view('superadmin.dashboard');
    })->name('superadmin.dashboard');


});




