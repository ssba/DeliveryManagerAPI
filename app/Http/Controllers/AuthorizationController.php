<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Validator;
use Hash;
use Config;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use App\User;
use Webpatser\Uuid\Uuid;

class AuthorizationController extends Controller
{
    /**
     * @param Request $request
     * @return array
     * @throws AuthorizationException
     * @throws ValidationException
     * @throws \Exception
     */
    public function getToken(Request $request) : array
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
            'password' => 'required',
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->all());

        $user = User::where('email', $request->email)->firstOrFail();

        if (!Hash::check($request->password, $user->password))
            throw new AuthorizationException();

        $id = Uuid::generate(4)->string; // TODO Find out how can I use this id
        $time = Config::get('cache.seconds',3000);
        $token = hash('sha1', $user->email.$user->password.time()); // Для поиска

        $attributes = [
            "token" => $token,
            "seconds" => "$time",
            "active_till" => date("c", time() + $time),
            "user_agent" => $request->header('User-Agent'),
            "ip" => $request->ip(),
        ];

        if(!$this->initSession($user->guid, $request, $time, $attributes))
            throw new \Exception();

        $attributes["title"] = "Login";
        $object = [
            "data" => [
                "type" => "authorization",
                "id" => $id,
                "attributes" => $attributes,
                "relationships" => [
                    "staff" => [
                        "links" => [
                            "self" => "http://example.com/token/da39a3ee5e6b4b0d3255bfef95601890afd80709/relationships/user",
                        ],
                        "data" => [
                            "type" => "user",
                            "id" => $user->guid,
                        ],
                    ],
                ],
                "links" => [
                    "related" => [
                        [
                            "href" => route('authorizationRenewToken'),// TODO link
                            "attributes" => [
                                "title" => "Token renew link"
                            ]
                        ],
                        [
                            "href" => route('authorizationUnsetToken'),// TODO link
                            "attributes" => [
                                "title" => "Logout link"
                            ]
                        ]
                    ],
                ],
            ],
        ];

        return $object;
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     * @throws \Exception
     */
    public function renewToken(Request $request) : array
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required|min:40|max:45',
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->all());

        $id = Uuid::generate(4)->string;
        $token = $request->token;
        $time = Config::get('cache.seconds',3000);
        $session = Cache::get("user.session.".$request->token);

        if (is_null($session))
            throw new NotFoundHttpException();

        $old =  [
            "token" => $session["token"],
            "seconds" => $session["seconds"],
            "active_till" => $session["active_till"],
            "user_agent" => $session["user_agent"],
            "ip" => $session["ip"],
        ];

        $new = [
            "token" => $token,
            "seconds" => "$time",
            "active_till" => date("c", time() + $time),
            "user_agent" => $request->header('User-Agent'),
            "ip" => $request->ip(),
        ];

        Cache::forget("user.session.".$token);

        if(!$this->initSession($session['user'], $request, $time, $new))
            throw new \Exception();

        $object = [
            "data" => [
                "type" => "authorization",
                "id" => $id,
                "attributes" => [
                    "old" => $old,
                    "new" => $new,
                    "title" => "Renew token key",
                ],
                "relationships" => [
                    "staff" => [
                        "links" => [
                            "self" => "http://example.com/token/$token/relationships/user",
                        ],
                        "data" => [
                            "type" => "user",
                            "id" => $session['user'],
                        ],
                    ],
                ],
                "links" => [
                    "related" => [
                        "href" => route('authorizationUnsetToken'),// TODO link
                        "attributes" => [
                            "title" => "Logout link"
                        ]
                    ],
                ],
            ],
        ];

        return $object;

    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    public function unsetToken(Request $request) : array
    {

        $validator = Validator::make($request->all(), [
            'token' => 'required|min:40|max:45',
        ]);

        if ($validator->fails())
            throw new ValidationException($validator->errors()->all());

        $id = Uuid::generate(4)->string;
        $token = $request->token;
        $session = Cache::get("user.session.".$request->token);

        if (is_null($session))
            throw new NotFoundHttpException();

        $attributes =  [
            "token" => $session["token"],
            "seconds" => $session["seconds"],
            "active_till" => $session["active_till"],
            "user_agent" => $session["user_agent"],
            "ip" => $session["ip"],
            "title" => "Logout",
        ];

        Cache::forget("user.session.".$token);

        $object = [
            "data" => [
                "type" => "authorization",
                "id" => $id,
                "attributes" => $attributes,
                "relationships" => [
                    "staff" => [
                        "links" => [
                            "self" => "http://example.com/token/$token/relationships/user",
                        ],
                        "data" => [
                            "type" => "user",
                            "id" => $session['user'],
                        ],
                    ],
                ],
            ],
        ];

        return $object;

    }

    /**
     * @param $userGUID
     * @param $request
     * @param $time
     * @param $attributes
     * @return bool
     */
    private function initSession($userGUID, $request, $time, $attributes) : bool
    {
        try {
            if(!is_null(Cache::get("user.session.".$attributes["token"])))
                return true;

            $session = [
                "user" => $userGUID,
                "token" => $attributes["token"],
                "seconds" => $attributes["seconds"],
                "active_till" => $attributes["active_till"],
                "user_agent" => $attributes["user_agent"],
                "ip" => $attributes["ip"],
                "request" => (string) $request
            ];

            Cache::put("user.session.".$attributes["token"], $session, $time / 60);

            return true;

        } catch (\Exception $e){
            return false;
        }
    }

}