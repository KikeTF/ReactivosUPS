<?php

namespace ReactivosUPS\Http\Controllers;

use ReactivosUPS\ExamState;
use ReactivosUPS\Location;
use ReactivosUPS\Period;
use ReactivosUPS\PeriodLocation;
use ReactivosUPS\ReagentState;
use Session;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use ReactivosUPS\Area;
use ReactivosUPS\CareerCampus;
use ReactivosUPS\Field;
use ReactivosUPS\MatterCareer;
use ReactivosUPS\Profile;
use ReactivosUPS\ProfileUser;
use ReactivosUPS\User;
use ReactivosUPS\Campus;
use ReactivosUPS\Format;
use Log;

abstract class Controller extends BaseController
{
    use DispatchesJobs, ValidatesRequests;

    var $abc = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U');

    /**
     * Retorna nombre completo del usuario.
     *
     * @param  int  $id
     * @return string $userName
     */
    public function getUserName($id){
        $userName = "";
        if( !is_null($id) ){
            $user = User::find($id);
            $userName = $user->nombres." ".$user->apellidos;
        }
        return $userName;
    }

    /**
     * Retorna listado de usuarios.
     */
    public function getUsers(){
        $contents = User::query()->orderBy('nombres', 'asc')->get();
        $contents = $contents->lists('FullName', 'id');
        return $contents;
    }

    /**
     * Retorna listado de ubicaciones por periodo.
     */
    public function getLocationPeriods(){
        $id_sede = (int)Session::get('idSede');
        $periodsLocations = PeriodLocation::query()->where('id_sede', $id_sede)->where('estado','A')->get();

        foreach ($periodsLocations as $periodoSede)
            $periods[$periodoSede->id] = $periodoSede->period->FullDescription;
        
        return (isset($periods) ? $periods : array());
    }

    /**
     * Retorna listado de sedes.
     */
    public function getLocations(){
        $locations = Location::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $locations;
    }

    /**
     * Retorna listado de campus.
     */
    public function getCampuses(){
        $campus = Campus::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $campus;
    }

    /**
     * Retorna listado de formatos de reactivos.
     */
    public function getFormats(){
        $formats = Format::query()->where('estado','A')->orderBy('id', 'asc')->lists('nombre','id');
        return $formats;
    }

    /**
     * Retorna listado de campos de conocimiento de reactivos.
     */
    public function getFields(){
        $fields = Field::query()->where('estado','A')->orderBy('nombre', 'asc')->lists('nombre','id');
        return $fields;
    }

    /**
     * Retorna listado de areas.
     */
    public function getAreas(){
        $areas = Area::query()->where('estado','A')->orderBy('descripcion', 'asc')->lists('descripcion','id');
        return $areas;
    }

    /**
     * Retorna listado de carreras por campus.
     */
    public function getCareersCampuses(){
        $careersCampuses = CareerCampus::query()->where('estado','A')->orderBy('id', 'asc')->get();
        return $careersCampuses;
    }

    /**
     * Retorna listado de materias por carreras.
     */
    public function getMattersCareers(){
        $mattersCareers = MatterCareer::query()->where('estado','A')->orderBy('id', 'asc')->get();
        return $mattersCareers;
    }

    /**
     * Retorna listado de estados de reactivos.
     */
    public function getReagentsStates(){
        $reagentsStates = ReagentState::query()
            ->where('estado','A')
            ->where('id','!=',7)
            ->orderBy('id', 'asc')->lists('descripcion','id');;
        return $reagentsStates;
    }

    /**
     * Retorna listado de formato de etiquetas (colores) de estados de reactivos.
     */
    public function getReagentsStatesLabel(){
        $statesLabel = ReagentState::query()
            ->where('estado','A')
            ->where('id','!=',7)
            ->orderBy('id', 'asc')->lists('etiqueta','id');;
        return $statesLabel;
    }

    /**
     * Retorna listado de estados de examenes.
     */
    public function getExamsStates(){
        $examsStates = ExamState::query()
            ->where('estado','A')
            ->where('id','!=',6)
            ->orderBy('id', 'asc')->lists('descripcion','id');;
        return $examsStates;
    }

    /**
     * Retorna parametros por materia.
     *
     * @param  int  $id_materia
     * @param  int  $id_carrera
     * @param  int  $id_campus
     * @return \ReactivosUPS\MatterCareer;  
     */
    public function getMatterParameters($id_materia, $id_carrera, $id_campus)
    {
        $id_careerCampus = $this->getCareersCampuses()
            ->where('id_carrera', $id_carrera)
            ->where('id_campus', $id_campus)
            ->where('estado', 'A')
            ->first()->id;

        $matterCareer = $this->getMattersCareers()
            ->where('id_carrera_campus', $id_careerCampus)
            ->where('aplica_examen', 'S');

        if($id_materia > 0)
            $matterCareer = $matterCareer->where('id_materia', $id_materia)->first();

        return $matterCareer;
    }

    /**
     * Valida si la sesion esta expirada.
     * 
     * @return bool;
     */
    public function isSessionExpire(){
        $result = false;
        try{
            if (!(\Session::has('idUsuario'))) {
                \Auth::logout();
                $result = true;
            }
        }catch (\Exception $ex){
            Log::error("La session ha expirado! ".$ex);
        }
        return $result;
    }

    /**
     * Carga variables de sesion.
     *
     * @param  int  $idPerfil
     * @param  int  $idUsuario
     * @return bool;
     */
    public function loadSessionData($idPerfil, $idUsuario){
        $result = false;
        try
        {
            Log::info("[Controller][loadSessionData] Datos: Usuario=".$idUsuario."; Perfil=".$idPerfil);

            $idSede = (int)User::find($idUsuario)->id_sede;

            $periodo = Period::query()
                ->where('estado', 'A')
                ->orderBy('fecha_inicio', 'desc')
                ->first();

            $idPeriodo = (int)$periodo->id;

            $idPerfilUsuario = (int)ProfileUser::query()
                ->where('id_perfil', $idPerfil)
                ->where('id_usuario', $idUsuario)
                ->first()->id;

            $idPeriodoSede = (int)PeriodLocation::query()
                ->where('id_periodo', $idPeriodo)
                ->where('id_sede', $idSede)
                ->first()->id;

            $perfil = Profile::find($idPerfil);
            $idsCarreras = $perfil->careersProfiles->pluck('id_carrera')->toArray();
            $aprReactivo = $perfil->aprueba_reactivo;
            $aprReactivosMasivo = $perfil->aprueba_reactivos_masivo;
            $desReactivos = $perfil->desbloquea_reactivos;
            $aprExamen = $perfil->aprueba_examen;
            $resetPassword = $perfil->restablece_password;
            $dashboard = $perfil->dashboard;

            $idsJefeAreas = ($aprExamen == 'S') ? [] : Area::query()->where('estado','A')->where('id_usuario_resp',\Auth::id())->get()->pluck('id')->toArray();

            Session::put('idUsuario', $idUsuario);
            Session::put('idSede', $idSede);
            Session::put('idPeriodo', $idPeriodo);
            Session::put('codPeriodo', $periodo->cod_periodo);
            Session::put('descPeriodo', $periodo->descripcion);
            Session::put('idPeriodoSede', $idPeriodoSede);
            Session::put('idPerfil', $idPerfil);
            Session::put('descPerfil', $perfil->nombre);
            Session::put('idsCarreras', $idsCarreras);
            Session::put('idsJefeAreas', $idsJefeAreas);
            Session::put('idPerfilUsuario', $idPerfilUsuario);
            Session::put('ApruebaReactivo', $aprReactivo);
            Session::put('ApruebaReactivosMasivos', $aprReactivosMasivo);
            Session::put('DesbloqueaReactivo', $desReactivos);
            Session::put('ApruebaExamen', $aprExamen);
            Session::put('RestablecePassword', $resetPassword);
            Session::put('Dashboard', $dashboard);
            $result = true;
        }
        catch (\Exception $ex){
            Log::error("[Controller][loadSessionData] Datos: Usuario=".$idUsuario."; Perfil=".$idPerfil.". Exception: ".$ex);
        }

        return $result;
    }

}
