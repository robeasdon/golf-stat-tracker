<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TeeType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tee_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'colour'];

    /**
     * A tee type has many tee sets
     */
    public function teeSets()
    {
        return $this->hasMany('App\TeeSet');
    }
}
