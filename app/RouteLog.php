<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class RouteLog extends Ardent
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
    protected $table = 'route_logs';

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
        'type', 'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'guid', 'type'
    ];

    /**
     * Validators rules for Ardent validator
     *
     * @var array
     */
    public static $rules = [
        'guid' => 'required|string|regex:/' . UUID_REGEXP_PATTERN. '/',
        'type' => 'required|string|exists:route_log_types,type',
        'route' => 'required|string|exists:car_route,guid|regex:/' . UUID_REGEXP_PATTERN. '/'
    ];
    // TODO Add 'updated_at' rule

    /**
     * Get Type
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function type()
    {
        return $this->hasOne('App\RouteLogType','type','type');
    }

    /**
     * Get Route
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function route()
    {
        return $this->hasOne('App\Product','guid','route');
    }
}
