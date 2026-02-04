<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\General;
use App\Models\Recibo;
use App\Models\Asistencia;

class CorteController extends Controller
{

    // Vista con resumen del corte
    public function index()
    {
        $general = General::firstOrFail();
        $aniomes = $general->aniomes;

        $recibos = Recibo::where('aniomes', $aniomes)
            ->where('cancelado', false)
            ->get();

        $totalImporte = $recibos->where('cancelado', 0)->sum('importe');
        $totalAsistentes = $recibos->where('asistio', true)->where('cancelado', true)->count();
        $totalCancelado = $recibos->where('cancelado', false)->count();

        return view('corte.index', compact('general', 'totalImporte', 'totalAsistentes', 'totalCancelado'));
    }

    // Reporte listo para imprimir en ticket
    public function print()
    {
        $general = General::firstOrFail();
        $aniomes = $general->aniomes;


        $anio= substr($aniomes, 0, 4);
        $mes= substr($aniomes, 4, 2);

        $recibos = Recibo::where('aniomes', $aniomes)
            ->where('cancelado', false)
            ->get();

        // $totalRecibos = Recibo::whereMonth('created_at', $mes)
        //     ->whereYear('created_at', $anio)
        //     ->where('cancelado', false)
        //     ->selectRaw('COUNT(*) as totalRecibos')
        //     ->first();



        $totalCancelado = Recibo::where('aniomes', $aniomes)
            ->where('cancelado', true)
            ->count();

        $totalImporte = $recibos->sum('importe');
   //     $totalAsistentes = $recibos->where('asistio', true)->count();

        $totalAsistentes = Asistencia::whereMonth('fecha', $mes)
             ->whereYear('fecha', $anio)
             ->where('cancelado', false)
             ->selectRaw('COUNT(*) as totalAsistentes')
             ->first();



        return view('corte.print', compact('general', 'totalImporte', 'totalAsistentes','totalCancelado', 'recibos'));
    }

    public function printDetalle()
    {
        $general = General::first();

        $recibos = Recibo::where('aniomes', $general->aniomes)
            // ->where('cancelado', false)
            ->with('asociado') // Relación belongsTo
            ->orderBy('created_at', 'asc')
            ->get();
        $totalImporte = $recibos->where('cancelado', false)->sum('importe');

        return view('corte.printDetalle', compact('general', 'recibos', 'totalImporte'));
    }

}
