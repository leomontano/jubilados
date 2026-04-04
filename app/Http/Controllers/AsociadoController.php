<?php

namespace App\Http\Controllers;

use App\Models\Asociado;
use App\Models\Asistencia;
use App\Models\Recibo;
use App\Models\HistorialMatricula;

use App\Http\Requests\SaveAsociadoRequest;

use Barryvdh\Debugbar\Facades\Debugbar;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

use Carbon\Carbon;

// use App\Http\Controllers\session;


class AsociadoController extends Controller
{

    /**
     * Display a listing of the resource.
     */


    public function index(Request $request)
    {
     //  dd($request);
        $request->validate([
            'matricula' => ['nullable','numeric'],
            'nombre' => ['nullable','regex:/^[\pL\s]+$/u','min:2'],
            'apellido' => ['nullable','regex:/^[\pL\s]+$/u','min:2'],
        ], [
            'nombre.regex' => 'El nombre solo puede contener letras y espacios.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'nombre.min' => 'Escribe al menos 2 letras para el nombre.',
            'apellido.regex' => 'Escribe al menos 2 letras para el apellido.',

        ]);
     //   debug('Request:', $request);
        $page = $request->query('page');
       // debug('page:', $page);
      //  debug('Request route:', $request->fullUrl());
        switch (true) {
            case $request->matricula:
                $asociados = Asociado::where('matricula', $request->matricula)->get();
                break;
            case ($request->nombre and $request->apellido):
                 $asociados = Asociado::where('nombre', $request->nombre)->Where('apellido', $request->apellido)->get();
               //  debug('asociados nombre y apellido:', $asociados);
                 if ($asociados->isEmpty()) {
                     $asociados = Asociado::where('nombre', 'like', "%{$request->nombre}%")
                         ->Where('apellido', 'like', "%{$request->apellido}%")
                         ->get();
                  //  debug('asociados segundo:', $asociados);
                 }
                 break;
            case ($request->nombre):
                 $asociados = Asociado::where('nombre', $request->nombre)->get();
               //  debug('asociados solo nombre:', $asociados);
                 if ($asociados->isEmpty()) {
                     $asociados = Asociado::where('nombre', 'like', "%{$request->nombre}%")->get();
                 //   debug('asociados solo nombre:', $asociados);
                 }
                 break;
            case ($request->apellido):
                 $asociados = Asociado::where('apellido', $request->apellido)->get();
              //   debug('asociados solo apellido:', $asociados);
                 if ($asociados->isEmpty()) {
                     $asociados = Asociado::where('apellido', 'like', "%{$request->apellido}%")->get();
                  //  debug('asociados solo apellido:', $asociados);
                 }
                 break;
            default:
                 $asociados = Asociado::latest()->take(12)->get();
               // $asociados = Asociado::orderBy('id', 'desc')->paginate(12);
        }
      // //  dd($asociados);
      //    debug('asociados:', $asociados);
            if ($asociados->isEmpty()) {
              //  debug('status');
                session()->flash('status','No encontré registros con los criterios de búsqueda');
            } 
          return view('asociados.index',['asociados' => $asociados]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('asociados.create',['asociado' => new Asociado]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SaveAsociadoRequest $request)
    {

       // debug('request del store:',$request->toArray());
        $validar=$request->validated();

        if($validar['fecha_nacimiento']){
            $validar['edad'] =  Carbon::parse($validar['fecha_nacimiento'])->age;
        }

        if($validar['fecha_jubilacion']){
            $validar['edad_jubilacion'] =  Carbon::parse($validar['fecha_jubilacion'])->age;
        }


        $validar['nombre'] = $this->quitarAcentos($validar['nombre']);
        $validar['apellido'] = $this->quitarAcentos($validar['apellido']);

        $validar['nombre'] = strtoupper($validar['nombre']);
        $validar['apellido'] = strtoupper($validar['apellido']);


      //  debug('validar del store:',$validar);
      //  Asociado::create($request->validated());
        Asociado::create($validar);


        session()->flash('status','Registro creado');
        return to_route('asociados.index');
    }

    /**
     * Display the specified resource.
     */
   // public function show(string $id)
    public function show(Asociado $asociado)
    {
        // return Asociado::findOrFail($id);
        // return $asociado;
        return view('asociados.show',['asociado' => $asociado]);
    }


    public function showmatricula($matricula)
    {
        $asociado = Asociado::where('matricula', $matricula)->firstOrFail();
        return view('asociados.showmatricula', compact('asociado'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asociado $asociado)
    {

        return view('asociados.edit',['asociado' => $asociado]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SaveAsociadoRequest $request, Asociado $asociado)
    {

        $validar=$request->validated();

        if($validar['fecha_nacimiento']){
            $validar['edad'] =  Carbon::parse($validar['fecha_nacimiento'])->age;
        }

        if($validar['fecha_jubilacion']){
            $validar['edad_jubilacion'] =  Carbon::parse($validar['fecha_jubilacion'])->age;
        }


        // debug('validar del store:',$validar);
        // debug('request:',$request->toArray());
        // debug('asociado:',$asociado->toArray());
        // debug('asociado id:',$asociado->id);

        $validar['nombre'] = $this->quitarAcentos($validar['nombre']);
        $validar['apellido'] = $this->quitarAcentos($validar['apellido']);

        $validar['nombre'] = strtoupper($validar['nombre']);
        $validar['apellido'] = strtoupper($validar['apellido']);

     //   dd($validar);


        $asociado = Asociado::find($asociado->id);
        $asociado->update($validar);

     //   Asociado::update($request->validated());
        session()->flash('status','Registro actualizado');
        return to_route('asociados.show', $asociado);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asociado $asociado)
    {
        $asociado->delete();
        return to_route('asociados.index')->with('status','Registro eliminado');
    }


    public function quitarAcentos($texto) {
        $buscar = array('Á','À','Ä','Â','á','à','ä','â',
                        'É','È','Ë','Ê','é','è','ë','ê',
                        'Í','Ì','Ï','Î','í','ì','ï','î',
                        'Ó','Ò','Ö','Ô','ó','ò','ö','ô',
                        'Ú','Ù','Ü','Û','ú','ù','ü','û',
                        'Ñ','ñ');
                        
        $reemplazar = array('A','A','A','A','a','a','a','a',
                            'E','E','E','E','e','e','e','e',
                            'I','I','I','I','i','i','i','i',
                            'O','O','O','O','o','o','o','o',
                            'U','U','U','U','u','u','u','u',
                            'N','n');

        return str_replace($buscar, $reemplazar, $texto);
    }




    // public function cambiarMatricula(Request $request, $matricula)
    // {

    //     $request->validate([
    //         'nueva_matricula' => 'required|unique:asociados,matricula'
    //     ]);

    //     DB::transaction(function () use ($request, $matricula) {

    //         $nueva = $request->nueva_matricula;

    //         // actualizar asociado
    //         DB::table('asociados')
    //             ->where('matricula', $matricula)
    //             ->update(['matricula' => $nueva]);

    //         // actualizar recibos
    //         DB::table('recibos')
    //             ->where('matricula', $matricula)
    //             ->update(['matricula' => $nueva]);

    //         // actualizar asistencias
    //         DB::table('asistencias')
    //             ->where('matricula', $matricula)
    //             ->update(['matricula' => $nueva]);

    //         // guardar historial
    //         HistorialMatricula::create([
    //             'matricula_anterior' => $matricula,
    //             'matricula_nueva' => $nueva,
    //             'usuario_id' => auth()->id()
    //         ]);

    //     });

    //     return redirect()->route('asociados.index')
    //         ->with('success','Matrícula actualizada correctamente');

    // }


    public function cambiarMatricula(Request $request)
    {

        $request->validate([
            'matricula_actual' => 'required|exists:asociados,matricula',
            'matricula_nueva' => 'required|numeric|unique:asociados,matricula'
        ]);

        $actual = $request->matricula_actual;
        $nueva  = $request->matricula_nueva;

        try {

            // Contar registros antes del cambio
            $recibosCount = DB::table('recibos')
                ->where('matricula', $actual)
                ->count();

            $asistenciasCount = DB::table('asistencias')
                ->where('matricula', $actual)
                ->count();

            $asociadoCount = DB::table('asociados')
                ->where('matricula', $actual)
                ->count();

            DB::transaction(function () use ($actual, $nueva) {

                $asociado = Asociado::where('matricula', $actual)->firstOrFail();

                $asociado->update([
                    'matricula' => $nueva
                ]);

                // guardar historial
                HistorialMatricula::create([
                    'matricula_anterior' => $actual,
                    'matricula_nueva' => $nueva,
                    'usuario_id' => auth()->id()
                ]);
                DB::commit();

            });

            $resultado = [
                'asociados' => $asociadoCount,
                'recibos' => $recibosCount,
                'asistencias' => $asistenciasCount,
                'mensaje' => 'Cambio realizado correctamente'
            ];

            return view('asociados.resultado_cambio_matricula', compact('resultado','actual','nueva'));

        } catch (\Exception $e) {

            $resultado = [
                'asociados' => 0,
                'recibos' => 0,
                'asistencias' => 0,
                'mensaje' => $e->getMessage()
            ];

            return view('asociados.resultado_cambio_matricula', compact('resultado','actual','nueva'));

        }

    }



    public function historial()
    {

        $historial = HistorialMatricula::latest()->paginate(20);

        return view('asociados.historial', compact('historial'));

    }


}
