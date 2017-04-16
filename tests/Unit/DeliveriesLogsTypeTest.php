<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeliveriesLogsTypeTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     *
     *
     * @return void
     */
    public function testGetAllUsersTypes()
    {
        fwrite(STDOUT,"Testing GET:delivery/logs/type/\n");

        $response = $this->json('GET', '/api/delivery/logs/type/');
        $schema  = $this->createJSONSchema('route_logs_type',"getAllDeliveryLogsTypes");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testGetSingleUsersType()
    {
        fwrite(STDOUT,"Testing GET:/delivery/logs/type/{typeGUID}\n");

        $RouteLogType = factory(\App\RouteLogType::class)->create();
        $response = $this->json('GET', "/api/delivery/logs/type/$RouteLogType->guid");

        $schema  = $this->createJSONSchema('route_logs_type',"getSingleDeliveryLogsType");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testCreateNewUsersType()
    {
        fwrite(STDOUT,"Testing POST:/delivery/logs/type/\n");

        $response = $this->json('POST', '/api/delivery/logs/type/', [
            'type' => "Type1",
            'desc' => 'desc'
        ]);

        $schema  = $this->createJSONSchema('route_logs_type',"createDeliveryLogsType");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testUpdateSingleUsersType()
    {
        fwrite(STDOUT,"Testing PUT:/delivery/logs/type/\n");

        $RouteLogType = factory(\App\RouteLogType::class)->create();
        $response = $this->json('PUT', "/api/delivery/logs/type/$RouteLogType->guid", [
            'type' => "Type1_UPDATE",
            'desc' => "desc_UPDATE"
        ]);

        $schema  = $this->createJSONSchema('route_logs_type',"getSingleDeliveryLogsType");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testDeleteSingleUsersType()
    {
        fwrite(STDOUT,"Testing DELETE:/delivery/logs/type/{typeGUID}\n");

        $RouteLogType = factory(\App\RouteLogType::class)->create();
        $response = $this->json('DELETE', "/delivery/logs/type/$RouteLogType->guid");
        $schema  = $this->createJSONSchema('route_logs_type',"getSingleDeliveryLogsType");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

}