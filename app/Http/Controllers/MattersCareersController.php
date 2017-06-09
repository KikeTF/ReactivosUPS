<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Career;
use ReactivosUPS\ContentDetail;
use ReactivosUPS\ContentHeader;
use ReactivosUPS\Distributive;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\Campus;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Area;
use ReactivosUPS\CareerCampus;
use Datatables;
use Log;
use ReactivosUPS\Mention;
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
        try{
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
            $id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);
            $id_careerCampus = 0;

            $area = Area::query()->where('estado','A')->where('id_usuario_resp',\Auth::id());
            $idJefeArea = ($area->count() > 0) ? $area->first()->id : 0;

            if($id_carrera > 0 && $id_campus > 0)
            {
                $id_careerCampus = $this->getCareersCampuses()
                    ->where('id_carrera', $id_carrera)
                    ->where('id_campus', $id_campus)
                    ->first()->id;
            }

            if( $idJefeArea > 0 )
                $mattersCareers = MatterCareer::filter($id_careerCampus, $id_mencion, $idJefeArea);
            else
                $mattersCareers = MatterCareer::filter($id_careerCampus, $id_mencion, $id_area);

            $mattersCareers = $mattersCareers->orderBy('id', 'desc')->get();

            if($mattersCareers->count() == 0)
                flash("No se encontro informaci&oacute;n!", 'warning');

            $filters = array($id_campus, $id_carrera, $id_mencion, (($idJefeArea > 0) ? -1 :$id_area));

            return view('general.matterscareers.index')
                ->with('campusList', $this->getCampuses())
                ->with('mattersCareers', $mattersCareers)
                //->with('campuses', $this->getCampuses())
                //->with('careers', $this->getCareers())
                ->with('areasList', $this->getAreas())
                //->with('mentions', $this->getMentions())
                ->with('filters', $filters);
        }catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[MattersCareersController][index] Exception: ".$ex);
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
        return redirect()->route('general.matterscareers.index');
    }

    /**
     * Store a newly created resource in storage.
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
        try{
            $mattercareer = MatterCareer::find($id);
            $mattercareer->desc_campus = Campus::find($mattercareer->careerCampus->id_campus)->descripcion;
            $mattercareer->desc_carrera = Career::find($mattercareer->careerCampus->id_carrera)->descripcion;
            $mattercareer->desc_mencion = $mattercareer->mention->descripcion;
            $mattercareer->desc_area = $mattercareer->area->descripcion;
            $mattercareer->desc_materia = $mattercareer->matter->descripcion;
            $mattercareer->usr_responsable = $this->getUserName($mattercareer->id_usr_responsable);
            $mattercareer->estado = ($mattercareer->estado == 'A') ? 'Activo' : 'Inactivo';
            $mattercareer->aplica_examen = ($mattercareer->aplica_examen == 'S') ? 'Si' : 'No';
            $mattercareer->creado_por = $this->getUserName($mattercareer->creado_por);
            $mattercareer->modificado_por = $this->getUserName($mattercareer->modificado_por);

            return view('general.matterscareers.show')->with('mattercareer', $mattercareer);
        }catch(\Exception $ex)
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
                ->with('mentionsList', $mentionsList);
        }
        catch(\Exception $ex)
        {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[MattersCareersController][edit] Datos: id=".$id.". Exception: ".$ex);
            return redirect()->route('general.matterscareers.index');
        }
    }

    public function download($id)
    {
        try
        {
            $matterCareer = MatterCareer::find($id);

            $file= base_path().'/storage/files/matters/UPS-MAT-'.$id.'.pdf';

            if ( file_exists($file) )
            {
                $filename = 'UPS-'.$matterCareer->matter->descripcion.'-'.$id.'.pdf';
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

            $matterCareer->id_mencion = $request->id_mencion;
            $matterCareer->nro_reactivos_mat = $request->nro_reactivos_mat;
            $matterCareer->nro_reactivos_exam = $request->nro_reactivos_exam;
            $matterCareer->aplica_examen = !isset( $request['aplica_examen'] ) ? 'N' : 'S';
            $matterCareer->estado = !isset( $request['estado'] ) ? 'I' : 'A';
            $matterCareer->modificado_por = \Auth::id();
            $matterCareer->fecha_modificacion = date('Y-m-d h:i:s');

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
                $request->file('archivo_contenido')->move(base_path().'/storage/files/matters/', $fileName);
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
            $matterCareer->fecha_modificacion = date('Y-m-d h:i:s');
            $matterCareer->save();

            flash('Transacci&oacuten realizada existosamente', 'success');
        }catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[MattersCareersController][destroy] Datos: id=".$id.". Exception: ".$ex);
        }

        return redirect()->route('general.matterscareers.index');
    }

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
            Log::error("[MattersCareersController][getMentionsList] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            $html = View::make('shared.optionlists._mentionslist')->render();
        }
        return \Response::json(['html' => $html]);
    }

    public function getMattersList(Request $request)
    {
        try
        {
            $aprReactivo = \Session::get('ApruebaReactivo');
            $aprExamen = \Session::get('ApruebaExamen');
            $id_Sede = (int)\Session::get('idSede');

            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_careerCampus = 0;
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
            $id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);

            if($aprReactivo == 'S')
            {
                $area = Area::query()->where('estado','A')->where('id_usuario_resp',\Auth::id());
                $id_area = ($area->count() > 0) ? $area->first()->id : 0;

                if($id_carrera > 0 && $id_campus > 0)
                {
                    $id_careerCampus = $this->getCareersCampuses()->where('id_carrera', $id_carrera)->where('id_campus', $id_campus)->first()->id;
                    $dist = MatterCareer::filter($id_careerCampus, $id_mencion, $id_area)->get();
                }
            }
            else
            {
                $dist = Distributive::query()
                    ->where('estado','A')
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

    public function getCareersList(Request $request)
    {
        try {
            $aprReactivo = \Session::get('ApruebaReactivo');
            $aprExamen = \Session::get('ApruebaExamen');
            $id_Sede = (int)\Session::get('idSede');

            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_mencion = (isset($request['id_mencion']) ? (int)$request->id_mencion : 0);
            $id_area = (isset($request['id_area']) ? (int)$request->id_area : 0);

            if ($aprExamen == 'S')
            {
                $careersList = Career::query();
            }
            elseif ($aprReactivo == 'S')
            {
                $area = Area::query()->where('estado','A')->where('id_usuario_resp',\Auth::id());
                $id_area = ($area->count() > 0) ? $area->first()->id : 0;

                if($id_campus > 0)
                    $id_careerCampus = CareerCampus::query()
                        ->where('estado','A')
                        ->where('id_campus', $id_campus)->first()->id;

                $dist = MatterCareer::filter($id_careerCampus, $id_mencion, $id_area)->get();

                if($dist->count() > 0)
                {
                    foreach ($dist as $car)
                    {
                        $ids[] = $car->careerCampus->id_carrera;
                    }
                }
            }
            else
            {
                $dist = Distributive::query()
                    ->where('estado','A')
                    ->where('id_campus', $id_campus)
                    ->where('id_sede', $id_Sede)
                    ->where('id_usuario', \Auth::id())->get();

                if($dist->count() > 0)
                {
                    foreach ($dist as $car)
                    {
                        $ids[] = $car->id_carrera;
                    }
                }
            }

            $careersList = Career::query();

            if(isset($ids))
                $careersList = $careersList->whereIn('id',$ids);

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

    public function getContentsList(Request $request)
    {
        try {
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
                $contentsList = ContentDetail::query()
                    ->where('estado','A')
                    ->where('id_contenido_cab',$id_content)
                    ->orderBy('capitulo', 'asc')->get();
            }

            if(isset($contentsList))
                $html = View::make('shared.optionlists._contentslist')->with('contentsList', $contentsList)->render();
            else
                $html = View::make('shared.optionlists._contentslist')->render();
        } catch (\Exception $ex) {
            Log::error("[MattersCareersController][getFormat] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
            $html = View::make('shared.optionlists._contentslist')->render();
        }
        return \Response::json(['html' => $html]);
    }
}
