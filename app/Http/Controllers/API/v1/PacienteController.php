<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use App\Models\Telefone;
use App\Http\Requests\API\v1\PacienteRequest;
use Illuminate\Support\Facades\Auth;

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try
        {
            $all = Paciente::with('telefone')->get();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Records founds successfully',
                'data' => $all
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Records founds failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PacienteRequest $request)
    {
        try
        {        
            $created = Paciente::create([
                'pac_nome'              => $request->pac_nome,
                'pac_dataNascimento'    => $request->pac_dataNascimento
            ]);

            if($request->pac_telefone){
                foreach($request->pac_telefone as $phone){
                    Telefone::create([
                        'pac_codigo' => $created->pac_codigo,
                        'tel_descricao' => $phone
                    ]);
                }
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Paciente created successfully',
                'pacientes' => $created
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Records created failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function show($paciente)
    {
        try
        {
            $found = Paciente::with('telefone')->findOrFail($paciente);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record found successfully',
                'data'   => $found
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Record found failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function update(PacienteRequest $request, $paciente)
    {
        try
        {
            $found = Paciente::with('telefone')->findOrFail($paciente);
            $found->pac_nome             = $request->pac_nome;
            $found->pac_dataNascimento   = $request->pac_dataNascimento;
            $found->update();

            if($request->pac_telefone){
                foreach($request->pac_telefone as $id => $phone){
                    Telefone::find($id)->update([
                        'tel_descricao' => $phone
                    ]);
                }
            }

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record updated successfully',
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Record updated failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Paciente  $paciente
     * @return \Illuminate\Http\Response
     */
    public function destroy($paciente)
    {
        try
        {
            $found = Paciente::findOrFail($paciente);
            $found->delete();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record deleted successfully',
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Records deleted failed',
                'details' => $e->getMessage()
            ],422);
        }
    }
}
