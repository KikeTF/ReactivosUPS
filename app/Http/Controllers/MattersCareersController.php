<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\MatterCareer;
use Datatables;

class MattersCareersController extends Controller
{
    var $filterCampus = 0;
    var $filterCareer = 0;
    var $filterMention = 0;
    var $filterArea = 0;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if( isset( $request['id_campus'] ) ){
            $this->filterCampus = (int)$request->id_campus;
            $this->filterCareer = (int)$request->id_carrera;
            $this->filterMention = (int)$request->id_mencion;
            $this->filterArea = (int)$request->id_area;
        }
        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $areas = $this->getAreas();
        $mentions = $this->getMentions();
        $filters = array($this->filterCampus, $this->filterCareer, $this->filterMention, $this->filterArea);
        return view('general.matterscareers.index')
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('areas', $areas)
            ->with('mentions', $mentions)
            ->with('filters', $filters);
    }

    public function data(Request $request)
    {

        if( isset( $request['id_campus'] ) ){
            $this->filterCampus = (int)$request->id_campus;
            $this->filterCareer = (int)$request->id_carrera;
            $this->filterMention = (int)$request->id_mencion;
            $this->filterArea = (int)$request->id_area;
        }

        $mattersCareers = MatterCareer::query()->where('estado','!=','E');

        if($this->filterCareer != 0 && $this->filterCampus != 0){
            $careersCampuses = $this->getCareersCampuses();
            $id_careerCampus = $careersCampuses
                ->where('id_carrera',$this->filterCareer)
                ->where('id_campus',$this->filterCampus)
                ->first()->id;
            $mattersCareers->where('id_carrera_campus',$id_careerCampus);
        }

        if($this->filterMention != 0){
            $mattersCareers->where('id_mencion',$this->filterMention);
        }

        if($this->filterArea != 0){
            $mattersCareers->where('id_area',$this->filterArea);
        }

        return Datatables::of($mattersCareers)
            ->addColumn('estado', function ($matterCareer) {
                if($matterCareer->estado == 'I')
                    $estado = 'Inactivo';
                elseif ($matterCareer->estado == 'A')
                    $estado = 'Activo';
                else
                    $estado = '';

                return $estado;
            })
            ->addColumn('action', function ($matterCareer) {
                return '<div class="hidden-sm hidden-xs action-buttons">
                            <a class="blue" href="'.route('general.matterscareers.show', $matterCareer->id).'">
                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                            </a>
                            <a class="green" href="'.route('general.matterscareers.edit', $matterCareer->id).'">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>
                            <a class="red" href="'.route('general.matterscareers.destroy', $matterCareer->id).'">
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
                                        <a href="'.route('general.matterscareers.show', $matterCareer->id).'" class="tooltip-info" data-rel="tooltip" title="View">
                                            <span class="blue"><i class="ace-icon fa fa-search-plus bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('general.matterscareers.edit', $matterCareer->id).'" class="tooltip-success" data-rel="tooltip" title="Edit">
                                            <span class="green"><i class="ace-icon fa fa-pencil-square-o bigger-120"></i></span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="'.route('general.matterscareers.destroy', $matterCareer->id).'" class="tooltip-error" data-rel="tooltip" title="Delete">
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
