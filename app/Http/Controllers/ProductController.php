<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Webpatser\Uuid\Uuid;
use App\Product;

class ProductController extends Controller
{
    public function getAll() : array
    {
        $data = [];
        $products = Product::all();

        foreach ($products as $key => $product){
            $data[] =[
                "type" => "products",
                "id" => $product->guid,
                "attributes" => $product,
                "links" => [
                    "self" => route('productsGetSingleProduct', ['productGUID' => $product->guid])
                ]
            ];
        }

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('productsGetAllProducts')
            ]
        ];

        return $json;
    }

    public function getSingle(string $productGUID) : array
    {
        $product = Product::where('guid', $productGUID)->firstOrFail();
        $data =[
            "type" => "products",
            "id" => $product->guid,
            "attributes" => $product
        ];


        $json = [
            "data" => $data,
            "links" => [
                "self" => route('productsGetSingleProduct', ['productGUID' => $product->guid])
            ]
        ];

        return $json;
    }

    public function createSingle(Request $request) : array
    {
        $newProductGUID = (string)Uuid::generate(4);

        $attributes = [
            "sku" => $request->sku,
            "name" => $request->name,
            "width" => $request->width,
            "height" => $request->height,
            "length" => $request->length,
            "volume" => $request->volume,
            "weight" => $request->weight,
            "image" => $request->image
        ];

        DB::transaction(function () use ($request, $attributes, $newProductGUID) {

            $attributes['guid'] = $newProductGUID;

            $status = new Product($attributes);

            if(!$status->save())
                throw new ValidationException($status->errors());

        });

        return $this->getSingle($newProductGUID);
    }

    public function updateSingle(string $productGUID, Request $request) : array
    {
        $product = Product::where('guid', $productGUID)->firstOrFail();
        $productRequest = $request->only('sku', 'name', 'width', 'height', 'length', 'volume', 'weight', 'image');

        if (empty($productRequest))
            return $this->getSingle($productGUID);

        DB::transaction(function () use ($request, $product, $productRequest) {

            $product_update = $product->update($productRequest);

            if (!$product_update)
                throw new ValidationException($product_update->errors());

        });

        return $this->getSingle($productGUID);
    }

    public function deleteSingle(string $productGUID) : array
    {
        $product = $this->getSingle($productGUID);

        DB::transaction(function () use ($productGUID) {
            Product::where('guid', $productGUID)->delete();
        });

        return $product;
    }

}

