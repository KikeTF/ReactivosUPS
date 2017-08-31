<?php

/**
 * NOMBRE DEL ARCHIVO   MattersCareersController.php
 *
 * TIPO                 Controlador
 *
 * DESCRIPCIÓN          Gestiona la consulta y modificación de
 *                      las materias por carrera.
 *
 * AUTORES              Neptalí Torres Farfán
 *                      Fátima Villalva Cabrera
 *
 * FECHA DE CREACIÓN    Julio 2017
 *
 */

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Career;
use ReactivosUPS\ContentDetail;
use ReactivosUPS\ContentHeader;
use ReactivosUPS\Distributive;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Matter;
use ReactivosUPS\Campus;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Area;
use ReactivosUPS\CareerCampus;
use Log;
use ReactivosUPS\Mention;
use ReactivosUPS\Profile;
use View;

class MattersCareersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try
        {
            $ids_carreras = \Session::get('idsCarreras');
            $ids_JefeAreas = \Session::get('idsJefeAreas');

            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
            $ids_areas = (sizeof($ids_JefeAreas) > 0) ? $ids_JefeAreas : (isset($request['id_area']) ? [(int)$request->id_area] : []);

            $mattersCareers = MatterCareer::with('careerCampus')
                ->whereHas('careerCampus', function($query) use($id_campus, $id_carrera, $ids_carreras){
                    if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                    if (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                });

            if ($id_mencion > 0)
                $mattersCareers = $mattersCareers->where('id_mencion', $id_mencion);

            if (sizeof($ids_areas) > 0)
                $mattersCareers = $mattersCareers->whereIn('id_area', $ids_areas);

            $mattersCareers = $mattersCareers->get();

            $filters = array($id_campus, $id_carrera, $id_mencion, ((sizeof($ids_areas) > 0 && !(sizeof($ids_JefeAreas) > 0)) ? $ids_areas[0] : -1));
            
            return view('general.matterscareers.index')
                ->with('campusList', $this->getCampuses())
                ->with('mattersCareers', $mattersCareers)
                ->with('areasList', $this->getAreas())
                ->with('filters', $filters);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[MattersCareersController][index] Exception: ".$ex);
            return redirect()->route('index');
        }
    }

    /**
     * Funcionalidad no requerida.
     * Redirecciona a la pagina index de Materias.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect()->route('general.matterscareers.index');
    }

    /**
     * Funcionalidad no requerida.
     * Redirecciona a la pagina index de Materias.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return redirect()->route('general.matterscareers.index');
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
            $mattercareer = MatterCareer::find($id);
            $mattercareer->creado_por = $this->getUserName($mattercareer->creado_por);
            $mattercareer->modificado_por = $this->getUserName($mattercareer->modificado_por);

            return view('general.matterscareers.show')->with('mattercareer', $mattercareer);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[MattersCareersController][show] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('general.matterscareers.index');
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
            $mattercareer = MatterCareer::find($id);
            
            $mentionsList = Mention::query()
                ->where('id_carrera', $mattercareer->careerCampus->id_carrera)
                ->where('estado', 'A')->lists('descripcion','id');

            return view('general.matterscareers.edit')
                ->with('mattercareer', $mattercareer)
                ->with('mentionsList', $mentionsList)
                ->with('areasList', $this->getAreas());
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[MattersCareersController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('general.matterscareers.index');
        }
    }

    /**
     * Descarga archivo de contenidos de la materias solicitada.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        try
        {
            $matterCareer = MatterCareer::find($id);

            $file= storage_path().'/files/matters/UPS-MAT-'.$id.'.pdf';

            if ( file_exists($file) )
            {
                $filename = 'UPS-'.preg_replace("/[^a-zA-Z0-9.]/", "", $matterCareer->matter->descripcion).'-'.$id.'.pdf';
                $headers = array('Content-Type: application/pdf',);
                return \Response::download($file, $filename, $headers);
            }
            else
            {
                flash("No se encontro el archivo!", 'warning')->important();
                $matterCareer->archivo_contenido = 'N';
                $matterCareer->save();
                return redirect()->route('general.matterscareers.edit', $id);
            }
        }
        catch(\Exception $ex)
        {
            flash("No se pudo descargar el archivo!", 'danger')->important();
            Log::error("[MattersCareersController][download] id=".$id.". Exception: ".$ex);
            return redirect()->route('general.matterscareers.edit', $id);
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
        try
        {
            $matterCareer = MatterCareer::find($id);

            \DB::beginTransaction(); //Start transaction!

            $matterCareer->id_area = $request->id_area;
            $matterCareer->id_mencion = $request->id_mencion;
            $matterCareer->nro_reactivos_mat = $request->nro_reactivos_mat;
            $matterCareer->nro_reactivos_exam = $request->nro_reactivos_exam;
            $matterCareer->aplica_examen = !isset( $request['aplica_examen'] ) ? 'N' : 'S';
            $matterCareer->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $matterCareer->modificado_por = \Auth::id();
            $matterCareer->fecha_modificacion = date('Y-m-d H:i:s');

            $matterCareer->archivo_contenido = 'N';
            $isValidFile = (bool)false;
            if ( isset($request['archivo_contenido']) && $request->hasFile('archivo_contenido') )
            {
                if ( $request->file('archivo_contenido')->isValid() )
                {
                    $matterCareer->archivo_contenido = 'S';
                    $isValidFile = (bool)true;
                }
            }

            $matterCareer->save();

            if ( $isValidFile )
            {
                $fileName = 'UPS-MAT-'.$id.'.'.$request->file('archivo_contenido')->getClientOriginalExtension();
                $request->file('archivo_contenido')->move(storage_path().'/files/matters/', $fileName);
            }

            flash('Transacci&oacuten realizada existosamente', 'success');
        }
        catch (\Exception $ex)
        {
            \DB::rollback();
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[MattersCareersController][update] id=".$id."; Exception: ".$ex);
            return redirect()->route('general.matterscareers.edit', $id);
        }
        finally
        {
            \DB::commit();
        }

        return redirect()->route('general.matterscareers.edit', $id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $matterCareer = MatterCareer::find($id);

        try
        {
            $matterCareer->estado = 'I';
            $matterCareer->modificado_por = \Auth::id();
            $matterCareer->fecha_modificacion = date('Y-m-d H:i:s');
            $matterCareer->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[MattersCareersController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }

        return redirect()->route('general.matterscareers.index');
    }

    /**
     * Obtiene listado de Menciones y retorna el codigo html en una vista parcial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMentionsList(Request $request)
    {
        try
        {
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);

            $mentionsList = Mention::query()
                ->where('id_carrera', $id_carrera)
                ->where('estado', 'A')->lists('descripcion','id');

            if($mentionsList->count() > 0)
                $html = View::make('shared.optionlists._mentionslist')
                    ->with('mentionsList', $mentionsList)
                    ->with('mentionFilter', $id_mencion)
                    ->render();
            else
                $html = View::make('shared.optionlists._mentionslist')->render();
        }
        catch (\Exception $ex) {
            Log::error("[MattersCareersController][getMentionsList] Exception: " . $ex);
            $html = View::make('shared.optionlists._mentionslist')->render();
        }
        return \Response::json(['html' => $html]);
    }

    /**
     * Obtiene listado de Materias y retorna el codigo html en una vista parcial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getMattersList(Request $request)
    {
        try
        {
            $aprReactivo = \Session::get('ApruebaReactivo');
            $aprExamen = \Session::get('ApruebaExamen');
            $id_periodo = (int)\Session::get('idPeriodo');
            $id_Sede = (int)\Session::get('idSede');
            $ids_carreras = \Session::get('idsCarreras');
            $ids_JefeAreas = \Session::get('idsJefeAreas');

            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_careerCampus = 0;
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
            $ids_areas = (sizeof($ids_JefeAreas) > 0) ? $ids_JefeAreas : (isset($request['id_area']) ? [(int)$request->id_area] : []);

            if($aprReactivo == 'S' || $aprExamen == 'S')
            {
                $mattersCareers = MatterCareer::with('careerCampus')
                    ->where('estado', 'A')
                    ->whereHas('careerCampus', function($query) use($id_campus, $id_carrera, $ids_carreras){
                        if ($id_campus > 0) $query->where('id_campus', $id_campus);
                        if ($id_carrera > 0) $query->where('id_carrera', $id_carrera);
                        elseif (sizeof($ids_carreras) > 0) $query->whereIn('id_carrera', $ids_carreras);
                    });

                if(sizeof($ids_areas) > 0)
                    $mattersCareers = $mattersCareers->whereIn('id_area', $ids_areas);

                $dist = $mattersCareers->get();
            }
            else
            {
                $dist = Distributive::query()
                    ->where('estado','A')
                    ->where('id_periodo', $id_periodo)
                    ->where('id_carrera', $id_carrera)
                    ->where('id_campus', $id_campus)
                    ->where('id_sede', $id_Sede)
                    ->where('id_usuario', \Auth::id())->get();
            }

            if(isset($dist))
            {
                $ids = array_unique($dist->pluck('id_materia')->toArray());
                $mattersList = Matter::query()->whereIn('id',$ids)->where('estado','A')->orderBy('descripcion','asc')->lists('descripcion','id');
            }

            $html = View::make('shared.optionlists._matterslist')
                ->with('mattersList', $mattersList)
                ->with('matterFilter', $id_materia)
                ->render();
        } catch (\Exception $ex) {
            Log::error("[MattersCareersController][getMattersList] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            $html = View::make('shared.optionlists._matterslist')->render();
        }
        return \Response::json(['html' => $html]);
    }

    /**
     * Obtiene listado de Carreras y retorna el codigo html en una vista parcial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getCareersList(Request $request)
    {
        try
        {
            $aprReactivo = \Session::get('ApruebaReactivo');
            $aprExamen = \Session::get('ApruebaExamen');
            $id_periodo = (int)\Session::get('idPeriodo');
            $id_Sede = (int)\Session::get('idSede');
            $id_Perfil = (int)\Session::get('idPerfil');
            $ids_JefeAreas = \Session::get('idsJefeAreas');
            $profile = Profile::find($id_Perfil);

            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
            //$id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);
            $ids_areas = (sizeof($ids_JefeAreas) > 0) ? $ids_JefeAreas : (isset($request['id_area']) ? [(int)$request->id_area] : []);


            if($aprReactivo == 'S' || $aprExamen == 'S')
            {
                $mattersCareers = MatterCareer::with('careerCampus')
                    ->where('estado', 'A')
                    ->whereHas('careerCampus', function($query) use($id_campus){
                        if ($id_campus > 0) $query->where('id_campus', $id_campus);
                    });

                if($id_mencion > 0)
                    $mattersCareers = $mattersCareers->where('id_mencion', $id_mencion);

                if(sizeof($ids_areas) > 0)
                    $mattersCareers = $mattersCareers->whereIn('id_area', $ids_areas);

                $dist = $mattersCareers->get();

                if($dist->count() > 0)
                    $ids = array_unique($dist->pluck('careerCampus')->pluck('id_carrera')->toArray());
            }
            else
            {
                $dist = Distributive::query()
                    ->where('estado','A')
                    ->where('id_periodo', $id_periodo)
                    ->where('id_campus', $id_campus)
                    ->where('id_sede', $id_Sede)
                    ->where('id_usuario', \Auth::id())->get();

                if($dist->count() > 0)
                    $ids = array_unique($dist->pluck('id_carrera')->toArray());
            }

            $careersList = Career::query();

            if(isset($ids))
                $careersList = $careersList->whereIn('id',$ids);

            if($profile->careersProfiles->count() > 0)
                $careersList = $careersList->whereIn('id', $profile->careersProfiles->pluck('id_carrera')->toArray());

            $careersList = $careersList->where('estado','A')->orderBy('descripcion','asc')->lists('descripcion','id');

            $html = View::make('shared.optionlists._careerslist')
                ->with('careersList', $careersList)
                ->with('careerFilter', $id_carrera)
                ->render();
        } catch (\Exception $ex) {
            Log::error("[MattersCareersController][getFormat] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            $html = View::make('shared.optionlists._careerslist')->render();
        }
        return \Response::json(['html' => $html]);
    }

    /**
     * Obtiene listado de Contenidos por Materia y retorna el codigo html en una vista parcial.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getContentsList(Request $request)
    {
        try 
        {
            $id_Sede = (int)\Session::get('idSede');
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_careerCampus = 0;
            $id_matterCareer = 0;
            $id_content = 0;

            if($id_carrera > 0 && $id_campus > 0)
            {
                $id_careerCampus = CareerCampus::query()
                    ->where('estado','A')
                    ->where('id_campus',$id_campus)->first()->id;
            }

            if($id_careerCampus > 0 && $id_materia > 0)
            {
                $id_matterCareer = MatterCareer::query()
                    ->where('estado','A')
                    ->where('id_materia',$id_materia)
                    ->where('id_carrera_campus',$id_careerCampus)->first()->id;
            }

            if($id_matterCareer > 0 && $id_materia > 0)
            {
                $id_content = ContentHeader::query()
                    ->where('estado','A')
                    ->where('id_materia_carrera',$id_matterCareer)->first()->id;
            }

            if($id_content > 0)
            {
                $contentHeader = ContentHeader::find($id_content);
                $content = $contentHeader->bibliografia_base."\n".$contentHeader->bibliografia_complementaria;
                $contentsList = ContentDetail::query()
                    ->where('estado','A')
                    ->where('id_contenido_cab',$id_content)
                    ->orderBy('capitulo', 'asc')->get();
            }

            if(isset($contentsList))
                $html = View::make('shared.optionlists._contentslist')->with('contentsList', $contentsList)->render();
            else
                $html = View::make('shared.optionlists._contentslist')->render();
        }
        catch (\Exception $ex)
        {
            Log::error("[MattersCareersController][getFormat] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            $html = View::make('shared.optionlists._contentslist')->render();
        }
        return \Response::json(['html' => $html, 'bibliografia' => (isset($content) ? $content : "") ]);
    }
}
