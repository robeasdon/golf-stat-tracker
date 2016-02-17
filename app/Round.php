<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Round extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rounds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['date'];

    /**
     * The attributes that are converted to instances of Carbon.
     *
     * @var array
     */
    protected $dates = ['date'];

    /**
     * A round has many scores.
     */
    public function scores()
    {
        return $this->hasMany('App\Score');
    }

    /**
     * A round belongs to a user.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * A round is played on a tee set.
     */
    public function teeSet()
    {
        return $this->belongsTo('App\TeeSet');
    }

    /**
     * Returns the total strokes
     *
     * @return mixed
     */
    public function totalStrokes()
    {
        return $this->scores->sum('strokes');
    }

    /**
     * Returns the total putts
     *
     * @return mixed
     */
    public function totalPutts()
    {
        return $this->scores->sum('putts');
    }

    /**
     * Returns the total score on par 3's
     *
     * @param $par
     * @return mixed
     */
    public function totalStrokesPar($par)
    {
        return $this->scores->filter(function ($score) use ($par) {
            return $score->hole->par === $par;
        })->sum('strokes');
    }

    public function totalEagles()
    {
        return $this->scores->filter(function ($score) {
            return $score->strokes - $score->hole->par === -2;
        })->count();
    }

    public function totalBirdies()
    {
        return $this->scores->filter(function ($score) {
            return $score->strokes - $score->hole->par === -1;
        })->count();
    }

    public function totalPars()
    {
        return $this->scores->filter(function ($score) {
            return $score->strokes - $score->hole->par === 0;
        })->count();
    }

    public function totalBogies()
    {
        return $this->scores->filter(function ($score) {
            return $score->strokes - $score->hole->par === 1;
        })->count();
    }

    public function totalDoubleBogies()
    {
        return $this->scores->filter(function ($score) {
            return $score->strokes - $score->hole->par === 2;
        })->count();
    }

    public function averagePutts()
    {
        return $this->scores->sum('putts') / $this->scores->count();
    }

    public function averageStrokesPar($par)
    {
        return $this->totalStrokesPar($par) / $this->scores->filter(function ($score) use ($par) {
            return $score->hole->par === $par;
        })->count();
    }
}
