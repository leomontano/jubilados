<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Asociado;
use App\Models\General;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        $anio = $request->get('anio', now()->year);
        $orden = $request->get('orden', 'apellido'); // 'matricula', 'apellido', 'nombre'
        $aniosDisponibles = range(now()->year - 5, now()->year + 2);

        // Consulta base filtrando asistencias válidas (no canceladas)
        $query = Asociado::whereHas('asistencias', function ($q) use ($anio) {
            $q->whereYear('fecha', $anio)->where('cancelado', false);
        });

        // Aplicar ordenamiento
        $asociados = $this->aplicarOrden($query, $orden)->get();

        // Obtener asistencias del año
        $asistencias = Asistencia::whereYear('fecha', $anio)
            ->where('cancelado', false)
            ->get();

        $asistenciaMatrix = [];
        foreach ($asistencias as $asistencia) {
            $mes = date('n', strtotime($asistencia->fecha));
            $asistenciaMatrix[$asistencia->matricula][$mes] = true;
        }

        return view('asistencias.index', compact(
            'asociados', 
            'asistenciaMatrix', 
            'anio', 
            'aniosDisponibles', 
            'orden'
        ));
    }

    public function reporte(Request $request, $anio)
    {
        $orden = $request->get('orden', 'apellido');
        $general = General::first();
        $asociacion = $general && $general->asociacion ? $general->asociacion : '';

        $query = Asociado::whereHas('asistencias', function($q) use ($anio) {
            $q->whereYear('fecha', $anio)->where('cancelado', false);
        })->with(['asistencias' => function($q) use ($anio) {
            $q->whereYear('fecha', $anio)->where('cancelado', false);
        }]);

        // Aplicar el mismo ordenamiento al reporte impreso
        $asociados = $this->aplicarOrden($query, $orden)->get();

        $asistenciaMatrix = [];
        foreach ($asociados as $asociado) {
            foreach ($asociado->asistencias as $asistencia) {
                $mes = Carbon::parse($asistencia->fecha)->month;
                $asistenciaMatrix[$asociado->matricula][$mes] = true;
            }
        }

        return view('asistencias.reporte', compact(
            'asociados', 
            'asistenciaMatrix', 
            'anio', 
            'asociacion', 
            'orden'
        ));
    }

    /**
     * Helper privado para centralizar las reglas de ordenamiento
     */
    private function aplicarOrden($query, string $orden)
    {
        return match ($orden) {
            'matricula' => $query->orderBy('matricula', 'asc'),
            'nombre'    => $query->orderBy('nombre', 'asc')->orderBy('apellido', 'asc'),
            default     => $query->orderBy('apellido', 'asc')->orderBy('nombre', 'asc'), // 'apellido'
        };
    }
}