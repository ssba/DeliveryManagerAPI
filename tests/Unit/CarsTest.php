<?php

namespace Tests\Unit;

use Tests\TestCase;
use Webpatser\Uuid\Uuid;
use Illuminate\Foundation\Testing\DatabaseMigrations;
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

        $response = $this->json('GET', '/api/cars/04a19620-2fbf-4047-a13a-cc5af0bbf22c');
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
            'width' => 20,
            'height' => 20,
            'area' => 20,
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

        $response = $this->json('POST', '/api/cars/a8180a0c-a3c9-4734-afda-841929cf2035', [
            'car' => 'CarName_Updates',
            'width' => 99,
            'height' => 99,
            'area' => 99,
        ]);

        $schema  = $this->createJSONSchema('cars',"updateCar");
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

        $generatedGUID = Uuid::generate(4);

        factory(\App\Car::class)->make([
            'guid' => $generatedGUID,
        ]);

        $response = $this->json('DELETE', '/api/cars/'.$generatedGUID );
        $schema  = $this->createJSONSchema('cars',"deleteCar");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }
}