<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use ReactivosUPS\ReagentAnswer;
use Session;


class ReagentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id_campus = (int)$request->id_campus;
        $id_carrera = (int)$request->id_carrera;
        $id_mencion = (int)$request->id_mencion;
        $id_materia = (int)$request->id_materia;

        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $mentions = $this->getMentions();
        $matters = $this->getMatters();

        $filters = array($id_campus, $id_carrera, $id_mencion, $id_materia);
        $reagents = Reagent::query()->get();

        return view('reagent.reagents.index')
            ->with('reagents', $reagents)
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('matters', $matters)
            ->with('mentions', $mentions)
            ->with('filters', $filters);
    }

    public function data(Request $request)
    {
        $id_distributivo = $this->getDistributive((int)$request->id_materia, (int)$request->id_carrera, (int)$request->id_campus)->id;

        $reagents = Reagent::filter($id_distributivo)->where('estado', '!=', 'E');

        return Datatables::of($reagents)
            ->addColumn('estado', function ($reagent) {
                if($matterCareer->estado == 'I')
                    $estado = 'Inactivo';
                elseif ($matterCareer->estado == 'A')
                    $estado = 'Activo';
                else
                    $estado = '';

                return $estado;
            })
            ->addColumn('action', function ($reagent) {
                return '<div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="'.route('reagent.reagents.show', $reagent->id).'">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="'.route('reagent.reagents.edit', $reagent->id).'">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="'.route('reagent.reagents.destroy', $reagent->id).'">
                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                            </a>
                        </div>
                        <div class="hidden-md hidden-lg">
                            <div class="inline pos-rel">
                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                    <li>
                                        <a href="'.route('reagent.reagents.show', $reagent->id).'" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('reagent.reagents.edit', $reagent->id).'" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('reagent.reagents.destroy', $reagent->id).'" class="tooltip-error" data-rel="tooltip" title="Delete">
                                            <span class="red"><i class="ace-icon fa fa-trash-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>';
            })
            ->make(true);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $mentions = $this->getMentions();
        $matters = $this->getMatters();
        $fields = $this->getFields();
        $formats = $this->getFormats();
        $contents = $this->getContents();
        $parameters = $this->getReagentParameters();
        return view('reagent.reagents.create')
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('matters', $matters)
            ->with('mentions', $mentions)
            ->with('contents', $contents)
            ->with('fields', $fields)
            ->with('formats', $formats)
            ->with('parameters', $parameters);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        $request->desc_op_resp_1;
        $request->arg_op_resp_1;
        $request->desc_op_resp_2;
        $request->arg_op_resp_2;
        $request->desc_op_resp_3;
        $request->arg_op_resp_3;
        $request->desc_op_resp_4;
        $request->arg_op_resp_4;
        */

        $parameters = $this->getReagentParameters();
        $answers = array();

        for($i = 1; $i <= $parameters->nro_opciones_resp_max; $i++){
            if( isset( $request['desc_op_resp_'.$i] ) ){
                $answer['id_opcion_resp'] = $i;
                $answer['descripcion'] = $request->input('desc_op_resp_'.$i);
                $answer['argumento'] = $request->input('arg_op_resp_'.$i);
                $answer['estado'] = 'A';
                $answer['creado_por'] = \Auth::id();
                $answer['fecha_creacion'] = date('Y-m-d h:i:s');
                $answers[] = new ReagentAnswer($answer);
            }
            //id
            //id_reactivo,
        }

        $reagent = new Reagent($request->all());

        $reagent->id_distributivo = $this->getDistributive((int)$request->id_materia, (int)$request->id_carrera, (int)$request->id_campus)->id;

        //$reagent->planteamiento= "Prueba";
        //$reagent->pregunta_opciones= "Prueba";
        $reagent->id_opcion_correcta= 1;
        //$reagent->puntaje = 9 ;
        //$reagent->referencia= "Prueba";

        $reagent->estado = !isset( $request['estado'] ) ? "I" : "A";
        $reagent->creado_por = \Auth::id();
        $reagent->fecha_creacion = date('Y-m-d h:i:s');
        $reagent->reagentsAnswers($answers);

        dd($reagent);

        //$reagent->save();

        return redirect()->route('reagent.reagents.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
