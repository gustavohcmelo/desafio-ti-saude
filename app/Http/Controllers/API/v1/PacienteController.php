<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $patients = Paciente::all()->sortBy('pac_nome');
        return response()->json([
            'status' => 'success',
            'message' => 'Records founds successfully',
            'pacientes' => $patients
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $patient = Paciente::create([
            'pac_nome' => $request->input('pac_nome', ''),
            'pac_dataNascimento' => $request->input('pac_dataNascimento', '')
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Paciente created successfully',
            'pacientes' => $patient
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show(Paciente $paciente)
    {
        Paciente::find($paciente);
        return response()->json([
            'status' => 'success',
            'message' => 'Record found successfully',
            'paciente' => $paciente
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paciente $paciente)
    {
        Paciente::find($paciente);
        $paciente->pac_nome = $request->input('pac_nome');
        $paciente->pac_dataNascimento = $request->input('pac_dataNascimento');
        $paciente->update();
        return response()->json([
            'status' => 'success',
            'message' => 'Record updated successfully',
            'paciente' => $paciente
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paciente $paciente)
    {
        Paciente::find($paciente);
        $paciente->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Record deleted successfully',
            'paciente' => $paciente
        ]);
    }
}
