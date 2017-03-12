<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class Delivery extends Ardent
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
    protected $table = 'delivery';

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
        'count'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'guid', 'route', 'product', 'count', 'created_at', 'updated_at'
    ];

    /**
     * Validators rules for Ardent validator
     *
     * @var array
     */
    public static $rules = [
        'guid' => 'required|string|regex:/' . UUID_REGEXP_PATTERN. '/',
        'route' => 'required|string|exists:car_route,guid|regex:/' . UUID_REGEXP_PATTERN. '/',
        'product' => 'required|string|exists:products,guid|regex:/' . UUID_REGEXP_PATTERN. '/',
        'count' => 'required|numeric'
    ];
    // TODO Add 'updated_at' rule

    /**
     * Get Route
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function route()
    {
        return $this->hasOne('App\CarRoute','guid','route');
    }


    /**
     * Get Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function product()
    {
        return $this->hasOne('App\RouteLogType','guid','product');
    }
}
