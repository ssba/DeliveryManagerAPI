<?php

namespace App;

use LaravelArdent\Ardent\Ardent;

class Product extends Ardent
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
    protected $table = 'products';

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
        'guid', 'sku', 'name', 'width', 'height', 'length', 'volume', 'weight', 'image'
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
        'sku' => 'required|string|max:36',
        'name' => 'required|string',
        'width' => 'required|numeric',
        'height' => 'required|numeric',
        'length' => 'required|numeric',
        'volume' => 'required|numeric',
        'weight' => 'required|numeric',
        'image' => 'string',
    ];
    // TODO Add 'updated_at' rule
}
