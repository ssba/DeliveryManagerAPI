<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class RouteLogType extends Ardent
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
    protected $table = 'route_log_types';

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
        'type', 'desc'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = ['guid'];

    /**
     * Validators rules for Ardent validator
     *
     * @var array
     */
    public static $rules = [
        'guid' => 'required|string|regex:/' . UUID_REGEXP_PATTERN. '/',
        'type' => 'required|string|unique:route_log_types,type',
        'desc' => 'required|string',
    ];
}
