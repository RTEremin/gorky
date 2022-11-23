<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\UserRegisterRequest;
use App\Http\Resources\BookingResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Авторизация в личном кабинете
     * @param UserLoginRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function login(UserLoginRequest $request)
    {
        if(auth()->attempt($request->validated())) {
            $user = auth()->user();
            $user->api_token = (string) Str::uuid();
            $user->save();
            return response(['token' => $user->api_token], 200);
        }
        return response([
            'error' => [
                'authorization' => 'Неверный логин или пароль'
            ]
        ], 401);
    }

    /**
     * Регистрация пользователя
     * @param UserRegisterRequest $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function register(UserRegisterRequest $request)
    {
        $user = User::create($request->validated());
        $user->api_token = (string) Str::uuid();
        $user->save();
        return response(['token' => $user->api_token], 201);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function userBookings(User $user)
    {
        return response(BookingResource::collection($user->bookings), 200);
    }
}
