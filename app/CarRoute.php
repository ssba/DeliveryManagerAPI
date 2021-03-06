<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class CarRoute extends Ardent
{

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
    protected $table = 'car_route';

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
        'lat', 'lng'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'guid', 'car', 'driver', 'created_at', 'updated_at'
    ];

    /**
     * Validators rules for Ardent validator
     *
     * @var array
     */
    public static $rules = [
        'guid' => 'required|string|regex:/' . UUID_REGEXP_PATTERN. '/',
        'car' => 'required|string|exists:cars,guid|regex:/' . UUID_REGEXP_PATTERN. '/',
        'driver' => 'required|string|exists:user,guid|regex:/' . UUID_REGEXP_PATTERN. '/',
        'lat' => 'required|numeric',
        'lng' => 'required|numeric',
    ];
    // TODO Add 'updated_at' rule

    /**
     * Get Car
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function car()
    {
        return $this->hasOne('App\Cars','guid','car');
    }

    /**
     * Get Driver
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function driver()
    {
        return $this->hasOne('App\User','guid','driver');
    }

}