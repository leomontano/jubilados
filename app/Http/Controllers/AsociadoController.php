<?php

namespace App\Http\Controllers;

use App\Models\Asociado;
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
        debug('Request:', $request);
        $page = $request->query('page');
        debug('page:', $page);
        debug('Request route:', $request->fullUrl());
        switch (true) {
            case $request->matricula:
                $asociados = Asociado::where('matricula', $request->matricula)->get();
                break;
            case ($request->nombre and $request->apellido):
                 $asociados = Asociado::where('nombre', $request->nombre)->Where('apellido', $request->apellido)->get();
                 debug('asociados nombre y apellido:', $asociados);
                 if ($asociados->isEmpty()) {
                     $asociados = Asociado::where('nombre', 'like', "%{$request->nombre}%")
                         ->Where('apellido', 'like', "%{$request->apellido}%")
                         ->get();
                    debug('asociados segundo:', $asociados);
                 }
                 break;
            case ($request->nombre):
                 $asociados = Asociado::where('nombre', $request->nombre)->get();
                 debug('asociados solo nombre:', $asociados);
                 if ($asociados->isEmpty()) {
                     $asociados = Asociado::where('nombre', 'like', "%{$request->nombre}%")->get();
                    debug('asociados solo nombre:', $asociados);
                 }
                 break;
            case ($request->apellido):
                 $asociados = Asociado::where('apellido', $request->apellido)->get();
                 debug('asociados solo apellido:', $asociados);
                 if ($asociados->isEmpty()) {
                     $asociados = Asociado::where('apellido', 'like', "%{$request->apellido}%")->get();
                    debug('asociados solo apellido:', $asociados);
                 }
                 break;
            default:
                 $asociados = Asociado::latest()->take(12)->get();
               // $asociados = Asociado::orderBy('id', 'desc')->paginate(12);
        }
      // //  dd($asociados);
      //    debug('asociados:', $asociados);
            if ($asociados->isEmpty()) {
                debug('status');
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


        debug('validar del store:',$validar);
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
}
