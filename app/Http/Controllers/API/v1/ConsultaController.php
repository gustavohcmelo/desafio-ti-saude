<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Models\Consulta_procedimento;
use App\Models\Consulta;
use Illuminate\Http\Request;

class ConsultaController extends Controller
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
            $all = Consulta::with(['paciente', 'medico'])->get();

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
            $created = Consulta::create([
                'pac_codigo'        => $request->pac_codigo,
                'med_codigo'        => $request->med_codigo,
                'cons_data'         => $request->cons_data,
                'cons_hora'         => $request->cons_hora,
                'cons_particular'   => $request->cons_particular
            ]);

            if($request->procedimento){
                $procedimento = $this->storeRelationConsultaProcedimento($created->cons_codigo, $request->procedimento);
                $created->procedimento = $procedimento;
            }

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
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function show($consulta)
    {
        try
        {
            $found = Consulta::with(['paciente', 'medico'])->findOrFail($consulta);

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
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $consulta)
    {
        try 
        {
            $found = Consulta::findOrFail($consulta);
            $found->pac_codigo          = $request->pac_codigo;
            $found->med_codigo          = $request->med_codigo;
            $found->cons_data           = $request->cons_data;
            $found->cons_hora           = $request->cons_hora;
            $found->cons_particular     = $request->cons_particular;
            $found->update();

            if($request->procedimento){
                $procedimento = $this->updateRelationConsultaProcedimento($consulta, $request->procedimento);
                $found->procedimento = $procedimento;
            }
    
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
     * @param  \App\Models\Consulta  $consulta
     * @return \Illuminate\Http\Response
     */
    public function destroy($consulta)
    {
        try
        {
            $found = Consulta::findOrFail($consulta);
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

    /**
     * Insert data to relation Model's Consulta and Procedimento.
     *
     * @param  \App\Models\Consulta  $consulta
     * @param  \App\Model\Procedimento $procedimento
     * @return \Illuminate\Http\Response
     */
    private function storeRelationConsultaProcedimento($consulta, $procedimento)
    {
        $created = Consulta_procedimento::create([
            'cons_codigo' => $consulta,
            'proc_codigo' => $procedimento
        ]);

        if(!$created){
            return false;
        }

        return $created->cons_proc_codigo;
    }

    /**
     * Insert data to relation Model's Consulta and Procedimento.
     *
     * @param  \App\Models\Consulta  $consulta
     * @param  \App\Model\Procedimento $procedimento
     * @return \Illuminate\Http\Response
     */
    private function updateRelationConsultaProcedimento($consulta, $procedimento)
    {
        $updated = Consulta_procedimento::where('cons_codigo', $consulta)->update([
            'proc_codigo' => $procedimento
        ]);

        if(!$updated){
            return false;
        }

        return Consulta_procedimento::with('procedimento')->findOrFail($consulta);
    }
}
