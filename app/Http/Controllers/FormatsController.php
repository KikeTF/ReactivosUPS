<?php

/**
 * NOMBRE DEL ARCHIVO   FormatsController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona la consulta, creación, modificación,
 *                      y eliminación de formatos de reactivos.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Format;
use ReactivosUPS\Http\Requests;
use Log;

class FormatsController extends Controller
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
            $formats = Format::query()->where('estado','!=','E')->get();
            return view('reagent.formats.index')
                ->with('formats', $formats);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[FormatsController][index] Exception: ".$ex);
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
        try
        {
            $format = new Format($request->all());
            $format->opciones_pregunta = !isset( $request['opciones_pregunta'] ) ? 'N' : 'S';
            $format->concepto_propiedad = !isset( $request['concepto_propiedad'] ) ? 'N' : 'S';
            $format->imagenes = !isset( $request['imagenes'] ) ? 'N' : 'S';
            $format->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $format->creado_por = \Auth::id();
            $format->fecha_creacion = date('Y-m-d H:i:s');
            $format->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[FormatsController][store] Exception: ".$ex);
            return view('reagent.formats.create');
        }

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
        try
        {
            $format = Format::find($id);
            $format->creado_por = $this->getUserName($format->creado_por);
            $format->modificado_por = $this->getUserName($format->modificado_por);

            return view('reagent.formats.show')->with('format', $format);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[FormatsController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('reagent.formats.index');
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
            $format = Format::find($id);
            return view('reagent.formats.edit')->with('format', $format);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[FormatsController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('reagent.formats.index');
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
        $format = Format::find($id);

        try
        {
            $format->nombre = $request->nombre;
            $format->descripcion = $request->descripcion;
            $format->opciones_resp_min = $request->opciones_resp_min;
            $format->opciones_resp_max = $request->opciones_resp_max;
            $format->opciones_pregunta = !isset( $request['opciones_pregunta'] ) ? 'N' : 'S';
            $format->concepto_propiedad = !isset( $request['concepto_propiedad'] ) ? 'N' : 'S';
            $format->opciones_preg_min = $request->opciones_preg_min;
            $format->opciones_preg_max = $request->opciones_preg_max;
            $format->opciones_prop_min = $request->opciones_prop_min;
            $format->opciones_prop_max = $request->opciones_prop_max;
            $format->imagenes = !isset( $request['imagenes'] ) ? 'N' : 'S';
            $format->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $format->modificado_por = \Auth::id();
            $format->fecha_modificacion = date('Y-m-d H:i:s');
            $format->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[FormatsController][update] Request=". implode(", ", $request->all()) ."; id=".$id."; Exception: ".$ex);
            return view('reagent.formats.edit')->with('format', $format);
        }

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

        try
        {
            $format->estado = 'E';
            $format->modificado_por = \Auth::id();
            $format->fecha_modificacion = date('Y-m-d H:i:s');
            $format->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[FormatsController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }

        return redirect()->route('reagent.formats.index');
    }
}
