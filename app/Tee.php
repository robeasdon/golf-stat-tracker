<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tee extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tees';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['yards'];

    /**
     * A tee belongs to a hole.
     */
    public function hole()
    {
        return $this->belongsTo('App\Hole');
    }

    /**
     * A tee belongs to a tee set
     */
    public function teeSet()
    {
        return $this->belongsTo('App\TeeSet');
    }
}
