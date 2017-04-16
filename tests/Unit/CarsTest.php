<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class CarsTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;


    /**
     *
     *
     * @return void
     */
    public function testGetAllCars()
    {
        fwrite(STDOUT,"Testing GET:/api/cars/\n");

        $response = $this->json('GET', '/api/cars');
        $schema  = $this->createJSONSchema('cars',"getAllCars");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testGetSingleCar()
    {
        fwrite(STDOUT,"Testing GET:/api/cars/{carGUID}\n");

        $car = factory(\App\Car::class)->create();
        $response = $this->json('GET', "/api/cars/$car->guid");
        $schema  = $this->createJSONSchema('cars',"getSingleCar");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testCreateNewCar()
    {
        fwrite(STDOUT,"Testing POST:/api/cars with ROOT\n");

        $response = $this->json('POST', '/api/cars', [
            'car' => 'CarName',
            'width' => "20",
            'height' => "20",
            'length' => "413.2",
            'capacity' => "413.2",
            'volume' => "413.2",
        ]);

        $schema  = $this->createJSONSchema('cars',"createCar");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testUpdateSingleCar()
    {
        fwrite(STDOUT,"Testing PUT:/api/cars/{carGUID}\n");

        $car = factory(\App\Car::class)->create();
        $response = $this->json('PUT', "/api/cars/$car->guid", [
            'car' => 'CarName_Updates',
            'width' => "22",
            'height' => "22",
            'length' => "415",
            'capacity' => "415",
            'volume' => "415",
        ]);

        $schema  = $this->createJSONSchema('cars',"getSingleCar");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testDeleteSingleCar()
    {
        fwrite(STDOUT,"Testing DELETE:/api/cars/{carGUID}\n");

        $car = factory(\App\Car::class)->create();
        $response = $this->json('DELETE', "/api/cars/$car->guid" );
        $schema  = $this->createJSONSchema('cars',"getSingleCar");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }
}