<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;

class MattersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('general.matters.index');
    }

    public function data()
    {
        $matters = Matter::query();
        return Datatables::of($matters)
            ->addColumn('estado', function ($matter) {
                if($matter->estado == 'I')
                    $estado = 'Inactivo';
                elseif ($matter->estado == 'A')
                    $estado = 'Activo';
                else
                    $estado = '';

                return $estado;
            })
            ->addColumn('action', function ($matter) {
                return '<div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="'.route('general.matters.show', ['id' => $matter->cod_materia]).'">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="'.route('general.matters.edit', ['id' => $matter->cod_materia]).'">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="'.route('general.matters.destroy', ['id' => $matter->cod_materia]).'">
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
                                        <a href="'.route('general.matters.show', ['id' => $matter->cod_materia]).'" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('general.matters.edit', ['id' => $matter->cod_materia]).'" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('general.matters.destroy', ['id' => $matter->cod_materia]).'" class="tooltip-error" data-rel="tooltip" title="Delete">
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
        return view('general.matters.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $matter = new Matter($request->all());

        if( !isset( $request['estado'] ) )
            $matter->estado = 'I';

        $matter->creado_por = Auth::user()->cod_usuario;
        $matter->fecha_creacion = date('Y-m-d h:i:s');
        $matter->save();

        return redirect()->route('general.matters.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $matter = Matter::find($id);
        return view('general.matters.show')->with('matter', $matter);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $matter = Matter::find($id);
        return view('general.matters.edit')->with('matter', $matter);
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
        $matter = Matter::find($id);

        if( !isset( $request['estado'] ) )
            $matter->estado = 'I';
        else
            $matter->estado = 'A';

        $matter->modificado_por = 'admin';
        $matter->fecha_modificacion = date('Y-m-d h:i:s');
        $matter->save();

        return redirect()->route('general.matters.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matter = Matter::find($id);

        $matter->estado = 'E';
        $matter->modificado_por = 'admin';
        $matter->fecha_modificacion = date('Y-m-d h:i:s');
        $matter->save();

        return redirect()->route('general.matters.index');
    }
}
