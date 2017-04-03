<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class Car extends Ardent
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
    protected $table = 'cars';

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
        'guid', 'car', 'width', 'height', 'length', 'capacity', 'volume'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'guid', 'created_at', 'updated_at'
    ];

    /**
     * Validators rules for Ardent validator
     *
     * @var array
     */
    public static $rules = [
        'guid' => 'required|string|regex:/' . UUID_REGEXP_PATTERN. '/',
        'car' => 'required|string',
        'width' => 'required|string',
        'height' => 'required|string',
        'length' => 'required|string',
        'capacity' => 'required|string',
        'volume' => 'required|string',
    ];
    // TODO Add 'updated_at' rule
}
