<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Services\AuthService;
use App\Services\RegisterService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Validator;

class UsersController extends Controller
{
    public function register(Request $request): Response
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'password_confirmation' => 'required|same:password',
            ]);

            if($validator->fails()){
                return ResponseHelper::sendError('Введенные данные не соответствуют критериям', $validator->errors());
            }

            $result = RegisterService::register($request);
            return ResponseHelper::sendSuccess($result, 'Пользователь успешно зарегистрирован');
        } catch (\Throwable $e) {
            return ResponseHelper::sendError('Ошибка при регистрации', $e->getMessage());
        }
    }

    public function login(Request $request): Response
    {
        try {
            return ResponseHelper::sendSuccess(AuthService::login($request));
        } catch (\Throwable $e) {
            return ResponseHelper::sendError('Ошибка при входе', $e->getMessage());
        }
    }
}
