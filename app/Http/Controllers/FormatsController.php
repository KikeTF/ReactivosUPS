<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Format;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
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
        $formats = Format::query()->where('estado','!=','E')->get();
        return view('reagent.formats.index')
            ->with('formats', $formats);
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
            $format->estado = 'I';

        $format->creado_por = \Auth::id();
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
        $format->creado_por = $this->getUserName($format->creado_por);
        $format->modificado_por = $this->getUserName($format->modificado_por);

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
        $format->modificado_por = \Auth::id();
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
        $format->modificado_por = \Auth::id();
        $format->fecha_modificacion = date('Y-m-d h:i:s');
        $format->save();

        return redirect()->route('reagent.formats.index');
    }
}
