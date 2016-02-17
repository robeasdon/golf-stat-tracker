<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeeSet extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tee_sets';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['sss'];

    /**
     * A tee set belongs to a course.
     */
    public function course()
    {
        return $this->belongsTo('App\Course');
    }

    /**
     * A tee set has many tees.
     */
    public function tees()
    {
        return $this->hasMany('App\Tee');
    }

    /**
     * A tee set has many rounds.
     */
    public function rounds()
    {
        return $this->hasMany('App\Round');
    }

    /**
     * A tee set has a tee type.
     */
    public function teeType()
    {
        return $this->belongsTo('App\TeeType');
    }

    public function totalYards()
    {
        return $this->tees->sum('yards');
    }
}
