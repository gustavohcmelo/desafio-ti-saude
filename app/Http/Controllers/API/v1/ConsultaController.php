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

            if($request->has('procedimento')){
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

            $procedimentos = $this->retrieveRelationConsultaProcedimento($consulta);
            $found->procedimento = $procedimentos;

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

            if($request->has('procedimento')){
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
    private function retrieveRelationConsultaProcedimento($consulta)
    {
        try {
            return Consulta_procedimento::with('procedimento')->whereHas('procedimento', function($p) use ($consulta){
                $p->where('cons_codigo', '=', $consulta);
            })->get();
        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Retrieve relation record failed',
                'details' => $e->getMessage()
            ]; 
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

        return [
            'relation'  => $created->cons_proc_codigo,
            'details'   => $created->procedimento
        ];
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
        try {
            $found = Consulta_procedimento::with('procedimento')->whereHas('procedimento', function($p) use ($consulta){
                $p->where('cons_codigo', '=', $consulta);
            })->get();

            $relation_found = Consulta_procedimento::find($found[0]->cons_proc_codigo)->update([
                'proc_codigo' => $procedimento
            ]);

            if($relation_found){
                return Consulta_procedimento::with('procedimento')->findOrFail($found[0]->cons_proc_codigo);
            }

            return false;

        } catch (\Exception $e) {
            return [
                'status' => 'error',
                'message' => 'Update relation record failed',
                'details' => $e->getMessage()
            ]; 
        }
    }
}
