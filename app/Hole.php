<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hole extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'holes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['number', 'par', 'si_mens'];

    /**
     * A hole belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    /**
     * A hole has many tees.
     */
    public function tees()
    {
        return $this->hasMany('App\Tee');
    }

    /**
     * A hole has many scores.
     */
    public function scores()
    {
        return $this->hasMany('App\Score');
    }
}
