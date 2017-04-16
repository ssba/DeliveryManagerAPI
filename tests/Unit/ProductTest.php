<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ProductTest extends TestCase
{
    use DatabaseTransactions;
    use WithoutMiddleware;

    /**
     *
     *
     * @return void
     */
    public function testGetAllProducts()
    {
        fwrite(STDOUT,"Testing GET:/api/products/\n");

        $response = $this->json('GET', '/api/products');
        $schema  = $this->createJSONSchema('products',"getAllProducts");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testGetSingleProduct()
    {
        fwrite(STDOUT,"Testing GET:/api/products/{productGUID}\n");

        $product = factory(\App\Product::class)->create();
        $response = $this->json('GET', "/api/products/$product->guid");

        $schema  = $this->createJSONSchema('products',"getSingleProduct");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testCreateNewProduct()
    {
        fwrite(STDOUT,"Testing POST:/api/products/\n");

        $response = $this->json('POST', '/api/products', [
            'sku' => 'CarName',
            'name' => 'ProductName',
            'width' => "20",
            'height' => "20",
            'length' => "413.2",
            'volume' => "413.2",
            'weight' => "413.2",
            'image' => null,

        ]);

        $schema  = $this->createJSONSchema('products',"createProduct");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testUpdateSingleProduct()
    {
        fwrite(STDOUT,"Testing PUT:/api/products/{productGUID}\n");

        $product = factory(\App\Product::class)->create();
        $response = $this->json('PUT', "/api/products/$product->guid", [
            'sku' => 'ProductSKU_UPDATE',
            'name' => 'ProductName_UPDATE',
            'width' => "20",
            'height' => "20",
            'length' => "413.2",
            'volume' => "413.2",
            'weight' => "413.2",
            'image' => null,
        ]);

        $schema  = $this->createJSONSchema('products',"getSingleProduct");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

    /**
     *
     *
     * @return void
     */
    public function testDeleteSingleProduct()
    {
        fwrite(STDOUT,"Testing DELETE:/api/products/{productGUID}\n");

        $product = factory(\App\Product::class)->create();
        $response = $this->json('DELETE', "/api/products/$product->guid");
        $schema  = $this->createJSONSchema('products',"createProduct");
        $this->JSONSchemaValidator->check( $response->getContent() , $schema );

        $this->assertTrue( $this->JSONSchemaValidator->isValid() );
        $response->assertStatus(200);
    }

}
