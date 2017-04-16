<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTypeTest extends TestCase
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
        fwrite(STDOUT,"Testing GET:users/types/\n");

        $response = $this->json('GET', '/api/users/types/');
        $schema  = $this->createJSONSchema('user_types',"getAllUserTypes");
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
        fwrite(STDOUT,"Testing GET:/users/types/{typeGUID}\n");

        $UserType = factory(\App\UserType::class)->create();
        $response = $this->json('GET', "/api/users/types/$UserType->guid");

        $schema  = $this->createJSONSchema('user_types',"getSingleUserType");
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
        fwrite(STDOUT,"Testing POST:/users/types/\n");

        $response = $this->json('POST', '/api/users/types', [
            'type' => "Type1",
            'desc' => 'desc'
        ]);

        $schema  = $this->createJSONSchema('user_types',"createUserType");
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
        fwrite(STDOUT,"Testing PUT:/users/types/{typeGUID}\n");

        $UserType = factory(\App\UserType::class)->create();
        $response = $this->json('PUT', "/api/users/types/$UserType->guid", [
            'type' => "Type1_UPDATE",
            'desc' => "desc_UPDATE"
        ]);

        $schema  = $this->createJSONSchema('user_types',"getSingleUserType");
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
        fwrite(STDOUT,"Testing DELETE:/users/types/{typeGUID}\n");

        $UserType = factory(\App\UserType::class)->create();
        $response = $this->json('DELETE', "/api/users/types/$UserType->guid");
        $schema  = $this->createJSONSchema('user_types',"getSingleUserType");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

}