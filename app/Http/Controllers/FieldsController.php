<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Field;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use App;
use Datatables;

class FieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reagent.fields.index');
    }

    public function data()
    {
        $fields = Field::query();
        return Datatables::of($fields)
            ->addColumn('estado', function ($field) {
                if($field->estado == 'I')
                    $estado = 'Inactivo';
                elseif ($field->estado == 'A')
                    $estado = 'Activo';
                else
                    $estado = '';

                return $estado;
            })
            ->addColumn('action', function ($field) {
                return '<div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="'.route('reagent.fields.show', ['id' => $field->cod_campo]).'">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="'.route('reagent.fields.edit', ['id' => $field->cod_campo]).'">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="'.route('reagent.fields.destroy', ['id' => $field->cod_campo]).'">
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
                                        <a href="'.route('reagent.fields.show', ['id' => $field->cod_campo]).'" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('reagent.fields.edit', ['id' => $field->cod_campo]).'" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('reagent.fields.destroy', ['id' => $field->cod_campo]).'" class="tooltip-error" data-rel="tooltip" title="Delete">
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
        return view('reagent.fields.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $field = new Field($request->all());

        if( !isset( $request['estado'] ) )
            $field->estado = 'I';

        $field->creado_por = 'admin';
        $field->fecha_creacion = date('Y-m-d h:i:s');
        $field->save();

        return redirect()->route('reagent.fields.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $field = Field::find($id);
        return view('reagent.fields.show')->with('field', $field);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $field = Field::find($id);
        return view('reagent.fields.edit')->with('field', $field);
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
        $field = Field::find($id);

        if( !isset( $request['estado'] ) )
            $field->estado = 'I';
        else
            $field->estado = 'A';

        $field->nombre = $request->nombre;
        $field->descripcion = $request->descripcion;
        $field->modificado_por = 'admin';
        $field->fecha_modificacion = date('Y-m-d h:i:s');
        $field->save();

        return redirect()->route('reagent.fields.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $field = Field::find($id);

        $field->estado = 'E';
        $field->modificado_por = 'admin';
        $field->fecha_modificacion = date('Y-m-d h:i:s');
        $field->save();

        return redirect()->route('reagent.fields.index');
    }
}
