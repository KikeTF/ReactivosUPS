<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Format;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use App;
use Datatables;

class FormatsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reagent.formats.index');
    }

    public function data()
    {
        $formats = Format::query();
        return Datatables::of($formats)
            ->addColumn('estado', function ($format) {
                if($format->estado == 'I')
                    $estado = 'Inactivo';
                elseif ($format->estado == 'A')
                    $estado = 'Activo';
                else
                    $estado = '';

                return $estado;
            })
            ->addColumn('action', function ($format) {
                return '<div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="'.route('reagent.formats.show', ['id' => $format->cod_formato]).'">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="'.route('reagent.formats.edit', ['id' => $format->cod_formato]).'">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="'.route('reagent.formats.destroy', ['id' => $format->cod_formato]).'">
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
                                        <a href="'.route('reagent.formats.show', ['id' => $format->cod_formato]).'" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('reagent.formats.edit', ['id' => $format->cod_formato]).'" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('reagent.formats.destroy', ['id' => $format->cod_formato]).'" class="tooltip-error" data-rel="tooltip" title="Delete">
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
        return view('reagent.formats.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $format = new Format($request->all());

        if( !isset( $request['estado'] ) )
            $format->estado = '0';

        $format->creado_por = 'admin';
        $format->fecha_creacion = date('Y-m-d h:i:s');
        $format->save();

        return redirect()->route('reagent.formats.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $format = Format::find($id);
        return view('reagent.formats.show')->with('format', $format);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $format = Format::find($id);
        return view('reagent.formats.edit')->with('format', $format);
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
        $format = Format::find($id);

        if( !isset( $request['estado'] ) )
            $format->estado = 'I';
        else
            $format->estado = 'A';

        $format->nombre = $request->nombre;
        $format->descripcion = $request->descripcion;
        $format->modificado_por = 'admin';
        $format->fecha_modificacion = date('Y-m-d h:i:s');
        $format->save();

        return redirect()->route('reagent.formats.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $format = Format::find($id);

        $format->estado = 'E';
        $format->modificado_por = 'admin';
        $format->fecha_modificacion = date('Y-m-d h:i:s');
        $format->save();

        return redirect()->route('reagent.formats.index');
    }
}
