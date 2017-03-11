<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Cache;

class AuthorizationTest extends TestCase
{

    use DatabaseTransactions;
    //TODO use DatabaseMigrations;


    /**
     * Get Token by credentials
     * @method POST
     * @return void
     */
    public function testGetTokenByCredentials()
    {
        fwrite(STDOUT,"Testing POST:/api/login with ROOT\n");

        $response = $this->json('POST', '/api/login', ['email' => 'root@example.com', 'password' => '1']);
        $schema  = $this->createJSONSchema('authorization',"login");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     * Get renew Token by token
     * @method PUT
     * @return void
     */
    public function testRenewToken()
    {
        fwrite(STDOUT,"Testing PUT:/api/login with ROOT\n");

        $testSession = [
            "user" => "1678733c-cf81-4aa9-aac7-ecda4d52f62b",
            "token" => hash('sha1', "UNITTEST".time()),
            "seconds" => 3000,
            "active_till" => date("c", time() + 3000),
            "user_agent" => "Mozilla/5.0 (Windows NT 6.2; rv:20.0) UnitTest Gecko/20121202 Firefox/20.0",
            "ip" => "127.0.0.1",
            "request" => null
        ];
        Cache::put("user.session.".$testSession["token"], $testSession, 3000 / 60);

        $response = $this->json('PUT', '/api/login', ['token' => $testSession["token"]]);
        $schema  = $this->createJSONSchema('authorization',"renewToken");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     * Unset Token
     * @method DELETE
     * @return void
     */
    public function testUnsetToken()
    {
        fwrite(STDOUT,"Testing PUT:/api/logout with ROOT\n");

        $testSession = [
            "user" => "1678733c-cf81-4aa9-aac7-ecda4d52f62b",
            "token" => hash('sha1', "UNITTEST".time()),
            "seconds" => 3000,
            "active_till" => date("c", time() + 3000),
            "user_agent" => "Mozilla/5.0 (Windows NT 6.2; rv:20.0) UnitTest Gecko/20121202 Firefox/20.0",
            "ip" => "127.0.0.1",
            "request" => null
        ];
        Cache::put("user.session.".$testSession["token"], $testSession, 3000 / 60);

        $response = $this->json('DELETE', '/api/logout', ['token' => $testSession["token"]]);
        $schema  = $this->createJSONSchema('authorization',"logout");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

}