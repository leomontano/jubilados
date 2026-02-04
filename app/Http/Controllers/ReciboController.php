<?php

namespace App\Http\Controllers;
use App\Models\Recibo;
use App\Models\Asociado;
use App\Models\General;
use App\Models\Asistencia;


use Barryvdh\Debugbar\Facades\Debugbar;

use Illuminate\Http\Request;
use Carbon\Carbon;
use NumberFormatter;

        use Mike42\Escpos\Printer;
        use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
        use Mike42\Escpos\PrintConnectors\FilePrintConnector;



class ReciboController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if($request->input('mes') and $request->input('anio')) {
            $mes = $request->input('mes', Carbon::now()->month);
            $anio = $request->input('anio', Carbon::now()->year);
        } else {
            $hoy = Carbon::now();
            $mes = $hoy->month;
            $anio = $hoy->year;
        }

        $recibos = Recibo::with('asociado')
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
        //    ->where('cancelado', false)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $totalMes = Recibo::whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->where('cancelado', false)
            ->sum('importe');

        $totalRecibos = Recibo::whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)
            ->where('cancelado', false)
            ->selectRaw('COUNT(*) as totalRecibos')
            ->first();


        // $totalCancelado = Recibo::whereMonth('created_at', $mes)
        //     ->whereYear('created_at', $anio)
        //     ->where('cancelado', true)
        //     ->sum('importe');

        $cancelados = Recibo::where('cancelado', true)
            ->whereMonth('created_at', $mes)
            ->whereYear('created_at', $anio)        
            ->selectRaw('COUNT(*) as totalCancelados, SUM(importe) as sumaCancelados')
            ->first();



        return view('recibos.index', compact('recibos', 'totalMes', 'cancelados', 'mes', 'anio', 'totalRecibos'));

        // $hoy = Carbon::now();

        // // Filtrar recibos del mes actual y unir con asociados
        // $recibos = Recibo::with('asociado')
        //     ->whereMonth('created_at', $hoy->month)
        //     ->whereYear('created_at', $hoy->year)
        //     ->where('cancelado', false)
        //     ->orderBy('created_at', 'desc')
        //     ->paginate(5); // 👈 Paginación de 15 en 15

        // // Total general del mes actual
        // $totalMes = Recibo::whereMonth('created_at', $hoy->month)
        //     ->whereYear('created_at', $hoy->year)
        //     ->sum('importe');

        // return view('recibos.index', compact('recibos', 'totalMes'));
     //   return view('recibos.index',['recibos', 'totalMes']);
    }



    public function indexmatricula($matricula)
    {
        // $asociado = Asociado::where('matricula', $matricula)
        //     ->with('recibos')
        //     ->firstOrFail();
        // if(!isset($matricula)) {
        //     return redirect()->route('recibo');
        // }

        $asociado = Asociado::where('matricula', $matricula)->firstOrFail();

        // Recibos ordenados y paginados
        $recibos = Recibo::where('matricula', $matricula)
            ->orderBy('created_at', 'desc')
            ->paginate(12); // <- aquí defines cuántos por página
        $totalImporte = Recibo::where('matricula', $matricula)->where('cancelado', false)->sum('importe');

        return view('recibos.indexmatricula', compact('asociado', 'recibos', 'totalImporte' ));
         
     //   return view('recibos.indexmatricula', compact('asociado', 'totalImporte'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        // Asociado
        $asociado = Asociado::where('matricula', $request->matricula)->firstOrFail();

        if (!$asociado) {
            return redirect()->back()->with('error', 'No se encontró un asociado con esa matrícula.');
        }
        $general = General::first();
        $recibo = new Recibo();
        $recibo->matricula = $asociado->matricula;
        $recibo->importe = $general->cuota;
        return view('recibos.create', compact('asociado', 'recibo'));



    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'matricula' => 'required|exists:asociados,matricula',
            'importe'   => 'required|numeric|min:0',
            'asistio'   => 'required|boolean',
        ], [
            'matricula.exists' => 'Error! No encontré la matrícula.',
            'importe.min' => 'El importe debe ser mayor a cero.',
            'asistio.required' => 'Selecciona Si o No si asistió a la junta del día.',
        ]);



        if($request->importe > 0) {

          //  $aniomes = Carbon::now()->format('Ym');
            $aniomes = date("Ym");
     
             // Control de folio desde la tabla generals
            $general = General::first();
            // dd('anomes:',$aniomes,$general->aniomes);
            if( $aniomes < $general->aniomes ){
                session()->flash('status','¡Error en control de folios, año y mes! ¡Recibo NO Grabado!, revisar fecha de computadora o reportar a administrador');
                return redirect()->route('recibomatricula', $request->matricula);
            }

            if( $aniomes === $general->aniomes ) {
                $general->foliomes = $general->foliomes + 1;
            } else {
                $general->foliomes = 1;
                $general->aniomes = $aniomes;
            }
            $general->folio = $general->folio + 1;
            // Crear recibo
            $recibo = new Recibo();
            $recibo->matricula = $request->matricula;
            $recibo->importe   = $request->importe;
            $recibo->foliomes  = $general->foliomes;
            $recibo->folio     = $general->folio;
            $recibo->aniomes   = $aniomes;
            $recibo->asistio   = $request->asistio;
            $recibo->matricula_a = $request->matricula;
            $recibo->save();

            $general->save();
        }


// grabado la asistencia

        if($request->asistio) {
            $hoy = date("Y-m-d");
            $exists = Asistencia::where('matricula', $request->matricula)
                                ->where('fecha', $hoy)
                                ->exists();
           // dd($request);
            if ($exists===false) {
                $asistencia = new Asistencia();
                $asistencia->matricula = $request->matricula;
                $asistencia->fecha   = $hoy;
                $asistencia->save();
            }
        }



// grabado Solo la asistencia

        if($request->asistio and $request->solo_asistencia == 1 and  $request->importe == 0) {
            return redirect()
                    ->route('asociados.index')
                    ->with('success', 'Asistencia registrada correctamente');
        }

        if(! $request->asistio and $request->solo_asistencia == 0 and  $request->importe == 0) {
            return redirect()
                    ->route('asociados.index')
                    ->with('success', 'No se realizó ninguna acción');
        }


        session()->flash('status','¡Recibo grabado con éxito!');
        // Redirigir a la impresión del ticket
        return redirect()->route('recibos.print', ['id' => $recibo->id, 'reimpresion' => 0]);

    }


    public function print($id, $reimpresion = null)
    {

     
      //  $recibo = Recibo::with('asociado')->findOrFail($id);
      //  $general = General::first();

        $esReimpresion = $reimpresion ? true : false;
       // dd($reimpresion);

        // Convertir importe a letras
     //   $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
   //     $importeLetras = ucfirst($formatter->format($recibo->importe));
      //  return view('recibos.print', compact('recibo', 'general', 'importeLetras', 'esReimpresion'));


            $recibo = Recibo::findOrFail($id);
            $asociado = Asociado::where('matricula', $recibo->matricula)->first();
            $general = General::first();

        $formatter = new NumberFormatter("es", NumberFormatter::SPELLOUT);
        $importeLetras = ucfirst($formatter->format($recibo->importe));


            try {
                // 🔹 Intentamos impresión ESC/POS
                if (class_exists(\Mike42\Escpos\Printer::class)) {
                    // dd('Escpos');
                    $this->printEscPos($recibo, $asociado, $general, $importeLetras, $esReimpresion);
                    return redirect()->route('asociados.index')->with('success', 'Recibo impreso en ticketera.');
                } else {
                    // 🔹 Si no existe la librería, fallback a HTML
                 //   dd('PRINT');
                    return view('recibos.print-html', 
                        compact('recibo', 'asociado', 'general', 'importeLetras', 'esReimpresion'));
                }
            } catch (\Exception $e) {
              //  dd($e);
                // 🔹 Si falla ESC/POS, fallback a HTML
                return view('recibos.print-html', compact('recibo', 'asociado', 'general', 'importeLetras', 'esReimpresion'))
                    ->with('error', "Fallo impresión en ticketera: " . $e->getMessage());
            }


    }


    // public function print2(Recibo $recibo)
    // {
    //     $asociado = Asociado::where('matricula', $recibo->matricula)->firstOrFail();
    //     $general  = General::firstOrFail();

    //     return view('recibos.print-ticket-80mm', compact(
    //         'recibo',
    //         'asociado',
    //         'general'
    //     ));
    // }



        // public function printTicket($id)
        // {
        //     $recibo = Recibo::findOrFail($id);
        //     $asociado = Asociado::where('matricula', $recibo->matricula)->first();
        //     $general = General::first();

        //     try {
        //         // 🔹 Intentamos impresión ESC/POS
        //         if (class_exists(\Mike42\Escpos\Printer::class)) {
        //             $this->printEscPos($recibo, $asociado, $general);
        //             return redirect()->route('asociados.index')->with('success', 'Recibo impreso en ticketera.');
        //         } else {
        //             // 🔹 Si no existe la librería, fallback a HTML
        //             return view('recibos.print-html', compact('recibo', 'asociado', 'general'));
        //         }
        //     } catch (\Exception $e) {
        //         // 🔹 Si falla ESC/POS, fallback a HTML
        //         return view('recibos.print-html', compact('recibo', 'asociado', 'general'))
        //             ->with('error', "Fallo impresión en ticketera: " . $e->getMessage());
        //     }
        // }



        /**
        * 🔹 Impresión directa con ESC/POS
        */
        private function printEscPos($recibo, $asociado, $general,  $importeLetras, $esReimpresion)
        {


        // Cambia el nombre según tu impresora compartida en Windows
        $esReimpresion = $esReimpresion ? true : false;
        $connector = new WindowsPrintConnector("POS-80");
        
        // En Linux: $connector = new FilePrintConnector("/dev/usb/lp0");

        $printer = new Printer($connector);



        // Encabezado
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text($general->asociacion . "\n");
        $printer->setTextSize(1, 1);
        $printer->text("Presidente: " . $general->presidente . "\n");
        $printer->text("--------------------------------\n");

        // Datos recibo
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->text("Recibo No: " . $recibo->id . "\n");
        $printer->text("Fecha: " . Carbon::parse($recibo->fecha)->format('d/m/Y') . "\n");
        $printer->text("Asociado: " . $asociado->nombre . "\n");
        $printer->text("Matrícula: " . $asociado->matricula . "\n");
        $printer->text("Importe: $" . number_format($recibo->importe, 2) . "\n");
        $printer->text("Son " . $importeLetras . "\n");

        if ($recibo->cancelado) {
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->setEmphasis(true);
            $printer->text("*** CANCELADO ***\n");
            $printer->setEmphasis(false);
        }



        $printer->text("--------------------------------\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text("¡Gracias por su aportación!\n");

        // Espacios + corte automático
        $printer->feed(4);
        $printer->cut();

        $printer->close();
       // dd('YA DENTRO DE POS-80'); 
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
        $recibo = Recibo::findOrFail($id);

        $recibo->cancelado = 1;
        $recibo->save();

        $fecha_asistencia  = date_format($recibo->created_at, 'Y-m-d');
        $asistencia = Asistencia::where('matricula', $recibo->matricula)
                            ->where('fecha', $fecha_asistencia);
       // dd($request);
        if ($asistencia) {
            $asistencia->delete();
        }


      //  $recibo->delete();
        return redirect()->back()->with('status', 'Recibo cancelado correctamente.');

    }
}