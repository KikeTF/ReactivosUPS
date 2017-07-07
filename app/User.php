<?php

namespace ReactivosUPS;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'seg_usuarios';

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['username', 'password', 'email', 'cod_usuario', 'nombres', 'apellidos', 'id_sede', 'tipo', 'estado', 'cambiar_password'];


    public function getPasswordAttribute()
    {
        return $this->attributes['password'];
    }

    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = \Hash::make($password);
    }

    public function getFullNameAttribute(){
        return $this->attributes['nombres'] .' '. $this->attributes['apellidos'];
    }

    public function profilesUsers(){
        return $this->hasMany('ReactivosUPS\ProfileUser', 'id_usuario');
    }

    public function location(){
        return $this->belongsTo('ReactivosUPS\Location', 'id_sede');
    }

    public function reagents(){
        return $this->hasMany('ReactivosUPS\Reagent', 'creado_por');
    }

    public function reagentsStates(){
        return $this->hasMany('ReactivosUPS\ReagentState', 'creado_por');
    }

    public function reagentsComments(){
        return $this->hasMany('ReactivosUPS\ReagentComment', 'creado_por');
    }

    public function examsComments(){
        return $this->hasMany('ReactivosUPS\ExamComment', 'creado_por');
    }

    public function notifications(){
        return $this->hasMany('ReactivosUPS\Notification', 'id_usuario');
    }
}
