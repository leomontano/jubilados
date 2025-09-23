<?php

namespace App\Http\Controllers;


use App\Models\General;

use Illuminate\Http\Request;



class GeneralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Tomamos el primer registro de la tabla general
        $general = General::first();
        session(['nombre_asociacion' => $general->asociacion]);
        session(['importe' => $general->cuota]);

        return view('welcome',['general' => $general]);
      //  return view('welcome', compact('general'));
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
    public function edit()
    {
        $general = General::first(); // primer registro
        $timezones = [
            'America/Mexico_City' => 'Ciudad de México',
            'America/Monterrey' => 'Monterrey',
            'America/Chihuahua' => 'Chihuahua',
            'America/Hermosillo' => 'Hermosillo',
            'America/Mazatlan' => 'Mazatlán',
            'America/Cancun' => 'Cancún'
        ]; // Zonas horarias de México

        return view('generals.edit', compact('general', 'timezones'));
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request)
    {
        $request->validate([
            'asociacion' => 'required|string|max:255',
            'presidente' => 'required|string|max:255',
            'cuota' => 'required|numeric|min:1',
            'timezone' => 'required|string',
        ], [
            'cuota.min' => 'El importe de la cuota debe ser mayo a ceros.',
        ]);

        $general = General::first();
        $general->update([
            'asociacion' => $request->asociacion,
            'presidente' => $request->presidente,
            'cuota' => $request->cuota,
            'timezone' => $request->timezone,
        ]);

        return redirect()->route('generals.edit')->with('success', 'Datos generales actualizados correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
