<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;

/**
 * Класс-сервис для регистрации пользователя
 *
 * Class RegisterService
 *
 * @package App\Services
 */
class RegisterService
{
    /**
     * Метод регистрирует пользователя
     *
     * @param Request $request
     *
     * @return array
     */
    public static function register(Request $request): array
    {
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);

        $user = User::create($input);

        $result['access_token'] = $user->createToken('Qtim Password Grant Client')->accessToken;
        $result['name'] = $user->name;

        return $result;
    }
}
