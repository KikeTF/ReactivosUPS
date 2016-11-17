<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Field;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
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
        $fields = Field::query()->where('estado','!=','E')->get();
        return view('reagent.fields.index')
            ->with('fields', $fields);
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

        $field->creado_por = \Auth::id();
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
        $field->creado_por = $this->getUserName($field->creado_por);
        $field->modificado_por = $this->getUserName($field->modificado_por);

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
        $field->modificado_por = \Auth::id();
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
        $field->modificado_por = \Auth::id();
        $field->fecha_modificacion = date('Y-m-d h:i:s');
        $field->save();

        return redirect()->route('reagent.fields.index');
    }
}
