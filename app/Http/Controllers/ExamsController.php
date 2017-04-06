<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\ExamDetail;
use ReactivosUPS\ExamHeader;
use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\Matter;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Reagent;
use Log;

class ExamsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);
            $id_estado = (isset($request['id_estado']) ? (int)$request->id_estado : 0);

            $filters = array($id_campus, $id_carrera, $id_materia, $id_estado);

            if ($id_campus > 0 && $id_carrera > 0 && $id_materia > 0) {
                $id_distributivo = $this->getDistributive($id_materia, $id_carrera, $id_campus)->id;
                if ($id_estado == 0)
                    $reagents = Reagent::filter($id_distributivo)->where('id_estado', '!=', 7);
                else
                    $reagents = Reagent::filter2($id_distributivo, $id_estado)->where('id_estado', '!=', 7);
            } else
                $reagents = Reagent::query()->where('id_estado', '!=', 7);

            $reagents = $reagents->orderBy('id', 'desc')->get();

            return view('exam.exams.index')
                ->with('reagents', $reagents)
                ->with('campuses', $this->getCampuses())
                ->with('careers', $this->getCareers())
                ->with('matters', $this->getMatters(0, 0, 0, 0))
                ->with('states', $this->getReagentsStates())
                ->with('statesLabels', $this->getReagentsStatesLabel())
                ->with('filters', $filters);
        } catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ExamsController][index] Request=" . implode(", ", $request->all()) . "; Exception: " . $ex);
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
        try {
            return view('exam.exams.create')
                ->with('campusList', $this->getCampuses())
                //->with('careers', $this->getCareers())
                ->with('matters', $this->getMatters(0, 0, 0, 0))
                ->with('mentions', $this->getMentions())
                ->with('contents', $this->getContentsModel())
                ->with('fields', $this->getFields())
                ->with('formats', $this->getFormats());
        } catch (\Exception $ex) {
            flash("No se pudo cargar la opci&oacute;n seleccionada!", 'danger')->important();
            Log::error("[ReagentsController][create] Exception: " . $ex);
            return redirect()->route('reagent.reagents.index');
        }
    }

    public function detail(Request $request, $id, $id_matter)
    {
        $id_materia = (int)$id_matter;
        $exam = ExamHeader::find($id);

        $reagents = Reagent::query()
            //->where('id_estado','5')
            ->where('id_sede', $exam->id_sede)
            ->where('id_periodo', $exam->id_periodo)
            ->where('id_campus', $exam->id_campus)
            ->where('id_carrera', $exam->id_carrera);
        
        foreach($reagents->get() as $reg)
        {
            $ids[] = $reg->id_materia;
        }

        if(isset($ids))
        {
            array_unique($ids);
            $mattersList = Matter::query()->whereIn('id',$ids)->where('estado','A')->orderBy('descripcion','asc')->get();
        }

        if($id_materia > 0)
        {
            $reagents = $reagents->where('id_materia', $id_materia)->get();
            $matterParameters = $this->getMatterParameters($id_materia, $exam->id_carrera, $exam->id_campus);
            //dd($exam->examsDetails()->reagent());
        }

        if(!isset($matterParameters))
            $matterParameters = array();

        return view('exam.exams.detail')
            ->with('matters', $mattersList)
            ->with('reagents', $reagents)
            ->with('exam', $exam)
            ->with('matterParameters', $matterParameters);
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
            $id_campus = (isset($request['id_campus']) ? (int)$request->id_campus : 0);
            $id_carrera = (isset($request['id_carrera']) ? (int)$request->id_carrera : 0);
            $id_careerCampus = $this->getCareersCampuses()->where('id_carrera', $id_carrera)->where('id_campus', $id_campus)->first()->id;

            $exam = new ExamHeader($request->all());
            $exam->es_prueba = !isset( $request['es_prueba'] ) ? 'N' : 'S';
            $exam->estado = 'A';
            $exam->id_sede = (int)\Session::get('idSede');
            $exam->id_periodo = (int)\Session::get('idPeriodo');
            $exam->id_periodo_sede = (int)\Session::get('idPeriodoSede');
            $exam->id_carrera_campus = $id_careerCampus;
            $exam->creado_por = \Auth::id();
            $exam->fecha_creacion = date('Y-m-d h:i:s');

            $exam->save();
            return redirect()->route('exam.exams.detail',['id' => $exam->id, 'id_matter' => 0]);
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamsController][store] Request=". implode(", ", $request->all()) ."; Exception: ".$ex);
            return redirect()->route('exam.exams.create');
        }

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
        //
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
        $id_materia = (isset($request['id_materia']) ? (int)$request->id_materia : 0);

        try
        {
            $exam = ExamHeader::find($id);

            foreach($exam->examsDetails as $det)
            {
                if($det->estado == 'A' && $det->reagent->id_materia == $id_materia)
                    $ids[] = $det->id_reactivo;
            }

            $idsDet = isset($ids) ? $ids : array();
            $idsReq = isset($request->id_reactivo) ? $request->id_reactivo : array();

            if( !($idsDet == $idsReq) )
            {
                $newIdsDet = array_diff($idsReq, $idsDet); //nuevos
                $delIdsDet = array_diff($idsDet, array_intersect($idsDet, $idsReq)); //eliminados

                if(sizeof($delIdsDet) > 0)
                {
                    foreach($delIdsDet as $det)
                    {
                        $examDet = ExamDetail::query()->where('id_examen_cab', $id)->where('id_reactivo', $det)->first();
                        $examDet->estado = 'E';
                        $examDet->modificado_por =  \Auth::id();
                        $examDet->fecha_modificacion =  date('Y-m-d h:i:s');
                        $examDetails[] = $examDet;
                    }
                }

                if(sizeof($newIdsDet) > 0)
                {
                    foreach($newIdsDet as $det)
                    {
                        if(ExamDetail::query()->where('id_examen_cab', $id)->where('id_reactivo', $det)->count() > 0)
                        {
                            $examDet = ExamDetail::query()->where('id_examen_cab', $id)->where('id_reactivo', $det)->first();
                            $examDet->estado = 'A';
                            $examDet->modificado_por =  \Auth::id();
                            $examDet->fecha_modificacion =  date('Y-m-d h:i:s');
                        }
                        else
                        {
                            $detail['id_examen_cab'] = $id;
                            $detail['id_reactivo'] = $det;
                            $detail['estado'] = 'A';
                            $examDet = new ExamDetail($detail);
                            $examDet->creado_por =  \Auth::id();
                            $examDet->fecha_creacion =  date('Y-m-d h:i:s');
                        }
                        $examDetails[] = $examDet;
                    }
                }
            }



            if(isset($examDetails))
            {
                try
                {
                    \DB::beginTransaction();
                    $exam->examsDetails()->saveMany($examDetails);
                    flash('Transacci&oacuten realizada existosamente', 'success');
                }
                catch (\Exception $ex)
                {
                    \DB::rollback();
                    flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
                    Log::error("[ExamsController][update] id=" . $id . "; Exception: " . $ex);
                }
                finally
                {
                    \DB::commit();
                }
            }
            else
            {
                flash("No se han realizado modificaciones", 'info');
            }
        }
        catch (\Exception $ex)
        {
            flash("No se pudo realizar la transacci&oacuten", 'danger')->important();
            Log::error("[ExamsController][update] id=" . $id . "; Exception: " . $ex);
            return redirect()->route('exam.exams.detail', ['id' => $id, 'id_matter' => 0]);
        }

        return redirect()->route('exam.exams.detail', ['id' => $id, 'id_matter' => $id_materia]);
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
