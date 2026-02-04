<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Asociado;
use App\Models\General;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request)
    {
        // Año actual si no se selecciona
        $anio = $request->get('anio', now()->year);

        // Rango de años (últimos 5 y próximos 2)
        $aniosDisponibles = range(now()->year - 5, now()->year + 2);

        // Asociados con al menos una asistencia en el año
        $asociados = \App\Models\Asociado::whereHas('asistencias', function ($query) use ($anio) {
            $query->whereYear('fecha', $anio);
        })->get();

        // Obtener asistencias del año
        $asistencias = \App\Models\Asistencia::whereYear('fecha', $anio)->where('cancelado', false)->get();

        // Arreglo [matricula][mes] => true
        $asistenciaMatrix = [];
        foreach ($asistencias as $asistencia) {
            $mes = date('n', strtotime($asistencia->fecha));
            $asistenciaMatrix[$asistencia->matricula][$mes] = true;
        }

        return view('asistencias.index', compact('asociados', 'asistenciaMatrix', 'anio', 'aniosDisponibles'));
    }


    public function reporte($anio)
    {
        $general = General::first();
        if($general->asociacion){
            $asociacion=$general->asociacion;
        } else {
            $asociacion="";
        }
        $asociados = Asociado::whereHas('asistencias', function($q) use ($anio) {
            $q->whereYear('fecha', $anio);
        })->with(['asistencias' => function($q) use ($anio) {
            $q->whereYear('fecha', $anio);
        }])->get();

        $asistenciaMatrix = [];
        foreach ($asociados as $asociado) {
            foreach ($asociado->asistencias as $asistencia) {
                $mes = \Carbon\Carbon::parse($asistencia->fecha)->month;
                $asistenciaMatrix[$asociado->matricula][$mes] = true;
            }
        }

        return view('asistencias.reporte', compact('asociados', 'asistenciaMatrix', 'anio','asociacion'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
