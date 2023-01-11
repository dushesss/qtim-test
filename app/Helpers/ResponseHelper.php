<?php

declare(strict_types=1);

namespace App\Helpers;

use Illuminate\Http\Response;

/**
 * Класс ResponseHelper позволяет унифицировать ответы в единый формат
 *
 * @package App\Helpers
 */
class ResponseHelper
{
    /**
     * Метод формирует массив с успешным ответом
     *
     * @param string|null $message
     * @param mixed $data
     * @param int $status
     * @return Response
     */
    public static function sendSuccess($data = null, string $message = null, int $status = 200): Response
    {
        $result = [
            'status' => true,
            'data' => $data,
            'message' => $message ?: 'Запрос успешно выполнен',
        ];

        return response($result, $status);
    }

    /**
     * Метод формирует массив с неудачным ответом
     *
     * @param array|string $errors
     * @param string|null $message
     * @param int $errorcode
     * @return Response
     */
    public static function sendError($errors = 'Неизвестная ошибка', $message = null, int $errorcode = 400): Response
    {
        $errors = !is_array($errors) ? [$errors] : $errors;

        return response([
            'status' => false,
            'message' => $message,
            'errors' => $errors,
        ], $errorcode);
    }
}
