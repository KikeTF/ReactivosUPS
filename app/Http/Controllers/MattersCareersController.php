<?php

namespace ReactivosUPS\Http\Controllers;

use Illuminate\Http\Request;

use ReactivosUPS\Http\Requests;
use ReactivosUPS\Http\Controllers\Controller;
use ReactivosUPS\MatterCareer;
use Datatables;

class MattersCareersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $areas = $this->getAreas();
        $mentions = $this->getMentions();
        return view('general.matterscareers.index')
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('areas', $areas)
            ->with('mentions', $mentions);
    }

    public function filter()
    {
        $campuses = $this->getCampuses();
        $careers = $this->getCareers();
        $areas = $this->getAreas();
        $mentions = $this->getMentions();
        return view('general.matterscareers.index')
            ->with('campuses', $campuses)
            ->with('careers', $careers)
            ->with('areas', $areas)
            ->with('mentions', $mentions);
    }

    public $filterCampus = 0;
    public $filterCareer = 0;
    public $filterArea = 0;
    public $filterMention = 0;

    public function data()
    {
        //if($filterCampus = 0)

        $mattersCareers = MatterCareer::query()->where('estado','!=','E');


        $mattersCareers = $mattersCareers->where('aplica_examen','N');
        //dd($mattersCareers);

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
