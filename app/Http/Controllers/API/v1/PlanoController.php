<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Plano;
use Illuminate\Http\Request;
use App\Http\Requests\API\v1\PlanoRequest;

class PlanoController extends Controller
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
            $all = Plano::all()->sortBy('plano_descricao');

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
    public function store(PlanoRequest $request)
    {
        try
        {
            $created = Plano::create([
                'plano_descricao'   => $request->plano_descricao,
                'plano_telefone'    => $request->plano_telefone
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Plano created successfully',
                'created'   => $created
            ]);
        } catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Plano created failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function show($plano)
    {
        try
        {
            $found = Plano::findOrFail($plano);

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
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function update(PlanoRequest $request, $plano)
    {
        try 
        {
            $found = Plano::findOrFail($plano);
            $found->plano_descricao  = $request->plano_descricao;
            $found->plano_telefone   =  $request->plano_telefone;
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
     * @param  \App\Models\Plano  $plano
     * @return \Illuminate\Http\Response
     */
    public function destroy($plano)
    {
        try
        {
            $found = Plano::findOrFail($plano);
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
