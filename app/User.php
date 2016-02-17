<?php

namespace App;

use DB;
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
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    /**
     * A user has many rounds.
     */
    public function rounds()
    {
        return $this->hasMany('App\Round');
    }

    /**
     * A user can follow many users.
     */
    public function following()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'user_id', 'follow_id')->withTimestamps();
    }

    /**
     * A user can be followed by many users.
     */
    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'follow_id', 'user_id')->withTimestamps();
    }

    /**
     * Check if a user is following another user.
     *
     * @param User $user
     * @return mixed
     */
    public function isFollowing(User $user)
    {
        return $this->following()->where('follow_id', $user->id)->exists();
    }

    /**
     * Follow a user.
     *
     * @param User $user
     */
    public function follow(User $user)
    {
        $this->following()->attach($user->id);
    }

    /**
     * Unfollow a user.
     *
     * @param User $user
     * @return int
     */
    public function unfollow(User $user)
    {
        $this->following()->detach($user->id);
    }
}