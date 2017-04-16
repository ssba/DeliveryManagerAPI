<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Webpatser\Uuid\Uuid;
use App\RouteLogType;

class DeliverysLogsTypeController extends Controller
{
    public function getAll() : array
    {
        $data = [];
        $RouteLogTypes = RouteLogType::all();

        foreach ($RouteLogTypes as $key => $RouteLogType){
            $data[] =[
                "type" => "route_logs_type",
                "id" => $RouteLogType->guid,
                "attributes" => $RouteLogType,
                "links" => [
                    "self" => route('route_logs_typeGetSingleDeliverysLogsType', ['typeGUID' => $RouteLogType->guid])
                ]
            ];
        }

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('route_logs_typeGetAllDeliverysLogsTypes')
            ]
        ];

        return $json;
    }

    public function getSingle(string $typeGUID) : array
    {
        $RouteLogType = RouteLogType::where('guid', $typeGUID)->firstOrFail();
        $data =[
            "type" => "user_types",
            "id" => $RouteLogType->guid,
            "attributes" => $RouteLogType
        ];


        $json = [
            "data" => $data,
            "links" => [
                "self" => route('$RouteLogType', ['typeGUID' => $RouteLogType->guid])
            ]
        ];

        return $json;
    }

    public function createSingle(Request $request) : array
    {
        $newRouteLogTypeGUID = (string)Uuid::generate(4);

        $attributes = [
            "type" => $request->type,
            "desc" => $request->desc,
        ];

        DB::transaction(function () use ($request, $attributes, $newRouteLogTypeGUID) {

            $attributes['guid'] = $newRouteLogTypeGUID;

            $status = new RouteLogType($attributes);

            if(!$status->save())
                throw new ValidationException($status->errors());

        });

        return $this->getSingle($newRouteLogTypeGUID);
    }

    public function updateSingle(string $typeGUID, Request $request) : array
    {
        $RouteLogType = RouteLogType::where('guid', $typeGUID)->firstOrFail();
        $RouteLogTypeRequest = $request->only('type', 'desc');

        if (empty($RouteLogTypeRequest))
            return $this->getSingle($typeGUID);

        DB::transaction(function () use ($request, $RouteLogType, $RouteLogTypeRequest) {

            $RouteLogType_update = $RouteLogType->update($RouteLogTypeRequest);

            if (!$RouteLogType_update)
                throw new ValidationException($RouteLogType_update->errors());

        });

        return $this->getSingle($typeGUID);
    }

    public function deleteSingle(string $typeGUID) : array
    {
        $RouteLogType = $this->getSingle($typeGUID);

        DB::transaction(function () use ($typeGUID) {
            RouteLogType::where('guid', $typeGUID)->delete();
        });

        return $RouteLogType;
    }

}