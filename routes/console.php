<?php

use App\Mail\RecordatorioCita;
use App\Models\Cita;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::call(function () {
    $manana = today()->addDay();

    $citas = Cita::where('estado', 'CONFIRMADA')
        ->whereDate('fecha', $manana)
        ->with(['usuario', 'peluquero', 'servicio'])
        ->get();

    // foreach ($citas as $cita) {
    //     Mail::to($cita->usuario->email)->send(new RecordatorioCita($cita));
    // }
})->dailyAt('10:00')->name('recordatorios-citas')->withoutOverlapping();
