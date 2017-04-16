<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class UserTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     *
     *
     * @return void
     */
    public function testGetAllUsers()
    {
        fwrite(STDOUT,"Testing GET:/api/users/\n");

        $response = $this->json('GET', '/api/users');
        $schema  = $this->createJSONSchema('users',"getAllUsers");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testGetSingleUser()
    {
        fwrite(STDOUT,"Testing GET:/api/users/{userGUID}\n");

        $user = factory(\App\User::class)->create();
        $response = $this->json('GET', "/api/cars/$user->guid");
        $schema  = $this->createJSONSchema('users',"getSingleUser");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testCreateNewUser()
    {
        fwrite(STDOUT,"Testing POST:/api/users/ \n");

        $userType = factory(\App\UserType::class)->create();
        $response = $this->json('POST', '/api/users/', [
            'type' => $userType->type,
            'email' => "mail@mail.mail",
            'password' => bcrypt("1"),
            'fname' => "John",
            'lname' => "Doe",
        ]);

        $schema  = $this->createJSONSchema('users',"getSingleUser");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testUpdateSingleUser()
    {
        fwrite(STDOUT,"Testing PUT:/api/users/{userGUID}\n");

        $user = factory(\App\User::class)->create();
        $userType = factory(\App\UserType::class)->create();
        $response = $this->json('PUT', "/api/users/$user->guid", [
            'type' => $userType->type,
            'email' => "mail@mail.mail",
            'password' => bcrypt("1"),
            'fname' => "John",
            'lname' => "Doe",
        ]);

        $schema  = $this->createJSONSchema('users',"getSingleUser");
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
        fwrite(STDOUT,"Testing DELETE:/api/users/{userGUID}\n");

        $user = factory(\App\User::class)->create();
        $response = $this->json('DELETE', "/api/users/$user->guid" );
        $schema  = $this->createJSONSchema('users',"getSingleUser");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }
}
