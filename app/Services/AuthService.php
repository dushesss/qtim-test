<?php

declare(strict_types=1);

namespace App\Services;

use App\Helpers\ResponseHelper;
use App\Models\User;
use App\Services\Passport\RequestPassport;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthService
{
    /**
     * Метод осущетвляет проверку авторизационных данных и авторизовывает пользователя в системе
     *
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
    public static function login(Request $request): array
    {
        $validator = Validator::make($request->all(), [
            'email' => 'email|required_without:login',
            'login' => 'max:255',
            'password' => 'required|min:5',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Неверные данные для входа');
        }

        $login = $request->email ?? $request->login;

        $response = RequestPassport::getInstance()->sendLogin($login, $request->password);

        if (isset($response['token_type']) && isset($response['access_token'])) {
            $user = (new User)->findForPassport($login);

            Auth::setUser($user);
        }

        if (isset($response['errors']) || isset($response['error'])) {
            $errorMessage = isset($response['errors']) ? current($response['errors']) : "Вы ввели не правильный логин или пароль";
            throw new \Exception($errorMessage);
        }

        return $response;
    }

    /**
     * Метод обновляет токен клиента
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public static function refreshToken(Request $request): Response
    {
        $validator = Validator::make($request->all(),[
            'refresh_token' => 'required',
        ]);

        if ($validator->fails()) {
            throw new \Exception('Отсутствует токен обновления');
        }

        try {
            $response = RequestPassport::getInstance()->sendRefresh($request->refresh_token);
            if (isset($response['error'])) {
                $result = ResponseHelper::sendError('Refresh token не валидный');
            } else {
                $result = ResponseHelper::sendSuccess($response);
            }
        } catch (\Exception $e) {
            $result = ResponseHelper::sendError($e->getMessage(), $e->getMessage());
        }

        return $result;
    }
}
