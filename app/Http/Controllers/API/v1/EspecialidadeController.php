<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Especialidade;
use Illuminate\Http\Request;

class EspecialidadeController extends Controller
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
            $epecs = Especialidade::all()->sortBy('espec_nome');

            return response()->json([
                'status' => 'success',
                'message' => 'Records founds successfully',
                'data' => $epecs
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
            $created = Especialidade::create([
                'espec_nome' => $request->espec_nome
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
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function show($especialidade)
    {
        try
        {
            $espec = Especialidade::findOrFail($especialidade);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record found successfully',
                'data'  => $espec
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
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $especialidade)
    {
        try 
        {
            $found = Especialidade::findOrFail($especialidade);
            $found->espec_nome = $request->espec_nome;
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
     * @param  \App\Models\Especialidade  $especialidade
     * @return \Illuminate\Http\Response
     */
    public function destroy($especialidade)
    {
        try
        {
            $found = Especialidade::findOrFail($especialidade);
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
