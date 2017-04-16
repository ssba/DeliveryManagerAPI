<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * Set not incremeniting ID.
     *
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Primary Key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'guid';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'guid', 'type', 'password', 'remember_token', 'role', 'created_at', 'updated_at'
    ];

    /**
     * Validators rules for Ardent validator
     *
     * @var array
     */
    public static $rules = [
        'guid' => 'required|string|regex:/' . UUID_REGEXP_PATTERN. '/',
        'type' => 'required|string|exists:user_types,type',
        'email' => 'required|string|email',
        'password' => 'required|string',
        'fname' => 'required|string',
        'lname' => 'required|string',
    ];

    public function role()
    {
        return $this->hasOne('App\UserType', 'type', 'type');
    }


}
