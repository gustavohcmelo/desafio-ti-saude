<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Paciente_plano;
use Illuminate\Http\Request;

class PacientePlanoController extends Controller
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
            $all = Paciente_plano::with(['paciente', 'plano'])->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Records founds successfully',
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
    public function store(Request $request)
    {
        try
        {
            $created = Paciente_plano::create([
                'pac_codigo'    => $request->pac_codigo,
                'plano_codigo'  => $request->plano_codigo,
                'nr_contrato'   => $request->nr_contrato
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record created successfully',
                'created'   => $created
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Record created failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Paciente_plano  $paciente_plano
     * @return \Illuminate\Http\Response
     */
    public function show($paciente_plano)
    {
        try
        {
            $found = Paciente_plano::with(['paciente', 'plano'])->findOrFail($paciente_plano);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record found successfully',
                'data'  => $found
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
     * @param  \App\Models\Paciente_plano  $paciente_plano
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $paciente_plano)
    {
        try 
        {
            $found = Paciente_plano::findOrFail($paciente_plano);
            $found->pac_codigo      = $request->pac_codigo;
            $found->plano_codigo    = $request->plano_codigo;
            $found->nr_contrato     = $request->nr_contrato;
            $found->update();
    
            return response()->json([
                'status'    => 'success',
                'message'   => 'Record updated successfully',
            ]);
        }
        catch (\Exception $e)
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
     * @param  \App\Models\Paciente_plano  $paciente_plano
     * @return \Illuminate\Http\Response
     */
    public function destroy($paciente_plano)
    {
        try
        {
            $found = Paciente_plano::findOrFail($paciente_plano);
            $found->delete();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record deleted successfully'
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Record delete failed',
                'details' => $e->getMessage()
            ],422);
        }
    }
}
