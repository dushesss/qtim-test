<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

class RegisterService
{
    public static function register(Request $request): array
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $result['access_token'] =  $user->createToken('Qtim Password Grant Client')->accessToken;
        $result['name'] =  $user->name;

        return $result;
    }
}
