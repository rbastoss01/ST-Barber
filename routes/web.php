<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Cliente\CitaController;
use App\Http\Controllers\Cliente\PerfilController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CitaAdminController;
use App\Http\Controllers\Admin\ServicioController;
use App\Http\Controllers\Admin\PeluqueroController;
use App\Http\Controllers\Admin\ClienteAdminController;
use App\Http\Controllers\Admin\HorarioController;

Route::get('/', [PublicController::class, 'inicio'])->name('inicio');
Route::get('/servicios', [PublicController::class, 'servicios'])->name('servicios');
Route::get('/informacion', [PublicController::class, 'informacion'])->name('informacion');

Route::post('/login', [LoginController::class, 'login'])->name('login');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/register', [RegisterController::class, 'register'])->name('register');
Route::get('/password/reset', [ForgotPasswordController::class, 'showForm'])->name('password.request');
Route::post('/password/email', [ForgotPasswordController::class, 'sendEmail'])->name('password.email');
Route::get('/password/reset/{token}', [ForgotPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/password/reset', [ForgotPasswordController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'es.cliente'])->group(function () {
    Route::get('/reservar/{servicio?}', [CitaController::class, 'formulario'])->name('citas.reservar');
    Route::post('/reservar', [CitaController::class, 'guardar'])->name('citas.guardar');
    Route::get('/mis-citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/mis-citas/{id}/editar', [CitaController::class, 'editar'])->name('citas.editar');
    Route::put('/mis-citas/{id}', [CitaController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/mis-citas/{id}', [CitaController::class, 'cancelar'])->name('citas.cancelar');
    Route::get('/mis-citas/{id}/confirmacion', [CitaController::class, 'confirmacion'])->name('citas.confirmacion');
    Route::get('/mis-citas/{id}/calendar.ics', [CitaController::class, 'descargarIcs'])->name('citas.ics');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil.index');
    Route::put('/perfil', [PerfilController::class, 'actualizar'])->name('perfil.actualizar');
});

Route::get('/disponibilidad', [CitaController::class, 'comprobarDisponibilidad'])->name('disponibilidad');

Route::middleware(['auth', 'es.admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/citas', [CitaAdminController::class, 'index'])->name('citas.index');
    Route::get('/citas/{id}', [CitaAdminController::class, 'show'])->name('citas.show');
    Route::put('/citas/{id}/confirmar', [CitaAdminController::class, 'confirmar'])->name('citas.confirmar');
    Route::put('/citas/{id}', [CitaAdminController::class, 'actualizar'])->name('citas.actualizar');
    Route::delete('/citas/{id}', [CitaAdminController::class, 'eliminar'])->name('citas.eliminar');
    Route::get('/citas/{id}/calendar.ics', [CitaAdminController::class, 'descargarIcs'])->name('citas.ics');

    Route::get('/servicios', [ServicioController::class, 'index'])->name('servicios.index');
    Route::get('/servicios/crear', [ServicioController::class, 'crear'])->name('servicios.crear');
    Route::post('/servicios', [ServicioController::class, 'guardar'])->name('servicios.guardar');
    Route::get('/servicios/{id}/editar', [ServicioController::class, 'editar'])->name('servicios.editar');
    Route::put('/servicios/{id}', [ServicioController::class, 'actualizar'])->name('servicios.actualizar');
    Route::delete('/servicios/{id}', [ServicioController::class, 'eliminar'])->name('servicios.eliminar');

    Route::get('/peluqueros', [PeluqueroController::class, 'index'])->name('peluqueros.index');
    Route::get('/peluqueros/crear', [PeluqueroController::class, 'crear'])->name('peluqueros.crear');
    Route::post('/peluqueros', [PeluqueroController::class, 'guardar'])->name('peluqueros.guardar');
    Route::get('/peluqueros/{id}/editar', [PeluqueroController::class, 'editar'])->name('peluqueros.editar');
    Route::put('/peluqueros/{id}', [PeluqueroController::class, 'actualizar'])->name('peluqueros.actualizar');
    Route::delete('/peluqueros/{id}', [PeluqueroController::class, 'eliminar'])->name('peluqueros.eliminar');
    Route::put('/peluqueros/{id}/ausencia', [PeluqueroController::class, 'toggleAusencia'])->name('peluqueros.ausencia');

    Route::get('/clientes', [ClienteAdminController::class, 'index'])->name('clientes.index');
    Route::get('/clientes/{id}', [ClienteAdminController::class, 'show'])->name('clientes.show');
    Route::delete('/clientes/{id}', [ClienteAdminController::class, 'eliminar'])->name('clientes.eliminar');

    Route::get('/horarios', [HorarioController::class, 'index'])->name('horarios.index');
    Route::put('/horarios', [HorarioController::class, 'actualizar'])->name('horarios.actualizar');
});