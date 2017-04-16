<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use DB;
use Webpatser\Uuid\Uuid;
use App\User;
use App\UserType;

class UserController extends Controller
{
    public function getAll() : array
    {
        $data = [];
        $Users = User::all();

        foreach ($Users as $key => $User){
            $data[] =[
                "type" => "users",
                "id" => $User->guid,
                "attributes" => $User,
                "relationships" => [
                    "role" => [
                        "links" => [
                            "self" => route('user_typesGetSingleUsersType', ['typeGUID' => $User->role->guid])
                        ],
                        "data" => [
                            "type" => "user_types",
                            "guid" => $User->role->guid,
                            "attributes" => $User->role
                        ],
                    ],
                ],
                "links" => [
                    "self" => route('userGetSingleUser', ['userGUID' => $User->guid])
                ]
            ];
        }

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('userGetAllUsers')
            ]
        ];
        return $json;
    }

    public function getSingle(string $userGUID) : array
    {
        $User = User::where('guid', $userGUID)->firstOrFail();

        $data =[
            "type" => "users",
            "id" => $User->guid,
            "attributes" => $User,
            "relationships" => [
                "role" => [
                    "links" => [
                        "self" => route('user_typesGetSingleUsersType', ['typeGUID' => $User->role->guid])
                    ],
                    "data" => [
                        "type" => "user_types",
                        "guid" => $User->role->guid,
                        "attributes" => $User->role
                    ],
                ],
            ]
        ];

        $json = [
            "data" => $data,
            "links" => [
                "self" => route('userGetSingleUser', ['userGUID' => $User->guid])
            ]
        ];
        return $json;
    }

    public function createSingle(Request $request) : array
    {
        $newUserGUID = (string)Uuid::generate(4);

        $attributes = [
            'type' => $request->type,
            'email' => $request->email,
            'password' => crypt($request->password),
            'fname' => $request->fname,
            'lname' => $request->lname,

        ];

        DB::transaction(function () use ($request, $attributes, $newUserGUID) {

            $attributes['guid'] = $newUserGUID;

            $status = new User($attributes);

            if(!$status->save())
                throw new ValidationException($status->errors());

        });

        return $this->getSingle($newUserGUID);
    }

    public function updateSingle(string $userGUID, Request $request) : array
    {
        $User = User::where('guid', $userGUID)->firstOrFail();
        $UserRequest = $request->only('type', 'email', 'password', 'fname', 'lname');

        if(!is_null($request->password))
            $request->password = crypt($request->password);

        if (empty($UserRequest))
            return $this->getSingle($userGUID);

        DB::transaction(function () use ($request, $User, $UserRequest) {

            $User_update = $User->update($UserRequest);

            if (!$User_update)
                throw new ValidationException($User_update->errors());

        });

        return $this->getSingle($userGUID);
    }

    public function deleteSingle(string $userGUID) : array
    {
        $User = $this->getSingle($userGUID);

        DB::transaction(function () use ($userGUID) {
            User::where('guid', $userGUID)->delete();
        });

        return $User;
    }

}