<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Procedimento;
use Illuminate\Http\Request;

class ProcedimentoController extends Controller
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
            $all = Procedimento::with('medico')->get();

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
            $created = Procedimento::create([
                'med_codigo'  => $request->med_codigo,
                'proc_nome'    => $request->proc_nome,
                'proc_valor'   => $request->proc_valor
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
     * @param  \App\Models\Procedimento  $procedimento
     * @return \Illuminate\Http\Response
     */
    public function show($procedimento)
    {
        try
        {
            $found = Procedimento::with('medico')->findOrFail($procedimento);

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
     * @param  \App\Models\Procedimento  $procedimento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $procedimento)
    {
        try 
        {
            $found = Procedimento::findOrFail($procedimento);
            $found->med_codigo  = $request->med_codigo;
            $found->proc_nome   = $request->proc_nome;
            $found->proc_valor  = $request->proc_valor;
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
     * @param  \App\Models\Procedimento  $procedimento
     * @return \Illuminate\Http\Response
     */
    public function destroy($procedimento)
    {
        try
        {
            $found = Procedimento::findOrFail($procedimento);
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
