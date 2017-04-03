<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Webpatser\Uuid\Uuid;
use App\Car;

class CarController extends Controller
{
    public function getAll() : array
    {
        $data = [];
        $cars = Car::all();

        foreach ($cars as $key => $car){
            $data[] =[
                "type" => "cars",
                "id" => $car->guid,
                "attributes" => $car,
                "links" => [
                    "self" => route('carsGetSingleCar', ['carGUID' => $car->guid])
                ]
            ];
        }

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('carsGetAllCars')
            ]
        ];

        return $json;
    }

    public function getSingle(string $carGUID) : array
    {
        $car = Car::where('guid', $carGUID)->firstOrFail();
        $data =[
            "type" => "cars",
            "id" => $car->guid,
            "attributes" => $car
        ];

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('carsGetSingleCar', ['carGUID' => $carGUID])
            ]
        ];

        return $json;
    }

    public function createSingle(Request $request) : array
    {
        $newCarGUID = (string)Uuid::generate(4);

        $attributes = [
            "car" => $request->car,
            "width" => $request->width,
            "height" => $request->height,
            "length" => $request->length,
            "capacity" => $request->capacity,
            "volume" => $request->volume
        ];

        DB::transaction(function () use ($request, $attributes, $newCarGUID) {

            $attributes['guid'] = $newCarGUID;

            $status = new Car($attributes);

            if(!$status->save())
                throw new ValidationException($status->errors());

        });

        return $this->getSingle($newCarGUID);
    }

    public function updateSingle(string $carGUID, Request $request) : array
    {
        $car = Car::where('guid', $carGUID)->firstOrFail();
        $carRequest = $request->only('car', 'width', 'height', 'length', 'capacity', 'volume');

        if (empty($carRequest))
            return $this->getSingle($carGUID);

        DB::transaction(function () use ($request, $car, $carRequest) {

            $car_update = $car->update($carRequest);

            if (!$car_update)
                throw new ValidationException($car_update->errors());

        });

        return $this->getSingle($carGUID);
    }

    public function deleteSingle(string $carGUID) : array
    {
        $car = $this->getSingle($carGUID);

        DB::transaction(function () use ($carGUID) {
            Car::where('guid', $carGUID)->delete();
        });

        return $car;
    }

}
