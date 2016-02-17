<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'scores';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['strokes', 'putts', 'fairway', 'gir'];

    /**
     * A score is recorded on a hole.
     */
    public function hole()
    {
        return $this->belongsTo('App\Hole');
    }

    /**
     * A score belongs to a round.
     */
    public function round()
    {
        return $this->belongsTo('App\Round');
    }
}
