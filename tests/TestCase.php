<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use JsonSchema\Validator as JsonSchemaValidator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Json Validator Object.
     *
     * @var string
     */
    protected $JSONSchemaValidator;

    public function __construct()
    {
        $this->JSONSchemaValidator = new JsonSchemaValidator();
    }

    public function createJSONSchema($type, $name){
        if(empty($type) || empty($name))
            return '{}';

        $path = realpath("tests\\JSON\\$type\\$name\\schema.json");
        $schema = file_get_contents($path);

        return empty($schema) ? "{}" : $schema;
    }
}
