<?php

/**
 * NOMBRE DEL ARCHIVO   FieldsController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona la consulta, creación, modificación,
 *                      y eliminación de campos de conocimiento de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Field;
use ReactivosUPS\Http\Requests;
use Log;

class FieldsController extends Controller
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
            $fields = Field::query()->where('estado','!=','E')->get();
            return view('reagent.fields.index')
                ->with('fields', $fields);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[FieldsController][index] Exception: ".$ex);
            return redirect()->route('index');
        }
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
        try
        {
            $field = new Field($request->all());
            $field->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $field->creado_por = \Auth::id();
            $field->fecha_creacion = date('Y-m-d H:i:s');
            $field->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[FieldsController][store] Exception: ".$ex);
            return view('reagent.fields.create');
        }
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
        try
        {
            $field = Field::find($id);
            $field->creado_por = $this->getUserName($field->creado_por);
            $field->modificado_por = $this->getUserName($field->modificado_por);

            return view('reagent.fields.show')->with('field', $field);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[FieldsController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('reagent.fields.index');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try
        {
            $field = Field::find($id);
            return view('reagent.fields.edit')->with('field', $field);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[FieldsController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('reagent.fields.index');
        }
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

        try
        {
            $field->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $field->nombre = $request->nombre;
            $field->descripcion = $request->descripcion;
            $field->modificado_por = \Auth::id();
            $field->fecha_modificacion = date('Y-m-d H:i:s');
            $field->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[FieldsController][update] id=".$id."; Exception: ".$ex);
            return view('reagent.$field.edit')->with('$field', $field);
        }
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
        try
        {
            $field->estado = 'E';
            $field->modificado_por = \Auth::id();
            $field->fecha_modificacion = date('Y-m-d H:i:s');
            $field->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[FieldsController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }
        return redirect()->route('reagent.fields.index');
    }
}
