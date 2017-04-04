<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Webpatser\Uuid\Uuid;
use App\UserType;

class UserTypeController extends Controller
{
    public function getAll() : array
    {
        $data = [];
        $UserTypes = UserType::all();

        foreach ($UserTypes as $key => $UserType){
            $data[] =[
                "type" => "user_types",
                "id" => $UserType->guid,
                "attributes" => $UserType,
                "links" => [
                    "self" => route('user_typesGetSingleUsersType', ['typeGUID' => $UserType->guid])
                ]
            ];
        }

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('user_typesGetAllUsersTypes')
            ]
        ];

        return $json;
    }

    public function getSingle(string $typeGUID) : array
    {
        $UserType = UserType::where('guid', $typeGUID)->firstOrFail();
        $data =[
            "type" => "user_types",
            "id" => $UserType->guid,
            "attributes" => $UserType
        ];


        $json = [
            "data" => $data,
            "links" => [
                "self" => route('user_typesGetSingleUsersType', ['typeGUID' => $UserType->guid])
            ]
        ];

        return $json;
    }

    public function createSingle(Request $request) : array
    {
        $newUserTypeGUID = (string)Uuid::generate(4);

        $attributes = [
            "type" => $request->type,
            "desc" => $request->desc,
        ];

        DB::transaction(function () use ($request, $attributes, $newUserTypeGUID) {

            $attributes['guid'] = $newUserTypeGUID;

            $status = new UserType($attributes);

            if(!$status->save())
                throw new ValidationException($status->errors());

        });

        return $this->getSingle($newUserTypeGUID);
    }

    public function updateSingle(string $typeGUID, Request $request) : array
    {
        $UserType = UserType::where('guid', $typeGUID)->firstOrFail();
        $UserTypeRequest = $request->only('type', 'desc');

        if (empty($UserTypeRequest))
            return $this->getSingle($UserType);

        DB::transaction(function () use ($request, $UserType, $UserTypeRequest) {

            $UserType_update = $UserType->update($UserTypeRequest);

            if (!$UserType_update)
                throw new ValidationException($UserType_update->errors());

        });

        return $this->getSingle($typeGUID);
    }

    public function deleteSingle(string $typeGUID) : array
    {
        $UserType = $this->getSingle($typeGUID);

        DB::transaction(function () use ($typeGUID) {
            UserType::where('guid', $typeGUID)->delete();
        });

        return $UserType;
    }

}