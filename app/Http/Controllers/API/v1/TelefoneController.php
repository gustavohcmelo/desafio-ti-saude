<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Telefone;
use App\Http\Requests\API\v1\TelefoneRequest;

class TelefoneController extends Controller
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
            $all = Telefone::all();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Records founds successfully',
                'data' => $all
            ]);
        }
        catch (\Exception $e)
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
    public function store(TelefoneRequest $request)
    {
        try
        {
            $phone = Telefone::create([
                'pac_codigo'            => $request->pac_codigo,
                'tel_descricao'         => $request->tel_descricao
            ]);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Telefone created successfully',
                'pacientes' => $phone
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'status' => 'error',
                'message' => 'Telefone created failed',
                'details' => $e->getMessage()
            ],422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Telefone  $telefone
     * @return \Illuminate\Http\Response
     */
    public function show($telefone)
    {
        try
        {
            $found = Telefone::findOrFail($telefone);

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record found successfully',
                'data'  => $found
            ]);
        }
        catch (\Exception $e)
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
     * @param  \App\Models\Telefone  $telefone
     * @return \Illuminate\Http\Response
     */
    public function update(TelefoneRequest $request, $telefone)
    {
        try
        {
            $found = Telefone::findOrFail($telefone);
            $found->pac_codigo      = $request->pac_codigo;
            $found->tel_descricao   = $request->tel_descricao;
            $found->update();

            return response()->json([
                'status'    => 'success',
                'message'   => 'Record updated successfully',
                'telefone'  => $found
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
     * @param  \App\Models\Telefone  $telefone
     * @return \Illuminate\Http\Response
     */
    public function destroy($telefone)
    {
        try
        {
            $found = Telefone::findOrFail($telefone);
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
                'message' => 'Record deleted failed',
                'details' => $e->getMessage()
            ],422);
        }
    }
}
