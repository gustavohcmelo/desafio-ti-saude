<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Consulta_procedimento;
use Illuminate\Http\Request;

class ConsultaProcedimentoController extends Controller
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
            $all = Consulta_procedimento::with(['procedimento', 'consulta'])->get();

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
            $created = Consulta_procedimento::create([
                'proc_codigo'   => $request->proc_codigo,
                'cons_codigo'   => $request->cons_codigo
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
     * @param  \App\Models\Consulta_procedimento  $consulta_procedimento
     * @return \Illuminate\Http\Response
     */
    public function show($consulta_procedimento)
    {
        try
        {
            $found = Consulta_procedimento::with(['paciente', 'plano'])->findOrFail($consulta_procedimento);

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
     * @param  \App\Models\Consulta_procedimento  $consulta_procedimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $consulta_procedimento)
    {
        try 
        {
            $found = Consulta_procedimento::findOrFail($consulta_procedimento);
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
     * @param  \App\Models\Consulta_procedimento  $consulta_procedimento
     * @return \Illuminate\Http\Response
     */
    public function destroy($consulta_procedimento)
    {
        try
        {
            $found = Consulta_procedimento::findOrFail($consulta_procedimento);
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
