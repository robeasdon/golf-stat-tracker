<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'courses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    /**
     * A course has many holes.
     */
    public function holes()
    {
        return $this->hasMany('App\Hole');
    }

    /**
     * A course can have many tee sets.
     */
    public function teeSets()
    {
        return $this->hasMany('App\TeeSet');
    }

    public function totalPar()
    {
        return $this->holes->sum('par');
    }
}
