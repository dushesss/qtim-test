<?php

declare(strict_types=1);

namespace App\Services\Passport;

use Illuminate\Http\Request;
use Exception;

/**
 * Класс RequestPassport посылает запрос на адреса Laravel Passport для работы с token
 *
 * @package App\Services\Passport
 */
class RequestPassport
{
    /**
     * @var string
     */
    private $clientId;
    /**
     * @var string
     */
    private $clientSecret;
    /**
     * @var string
     */
    private $grandType;
    /**
     * @var self
     */
    private static $instance;

    const LOGIN_PATH = "/oauth/token";
    const REFRESH_PATH = "/oauth/token";

    /**
     * RequestPassport constructor.
     *
     * @param null|string $clientId
     * @param null|string $clientSecret
     * @param null|string $grandType
     */
    private function __construct($clientId = null, $clientSecret = null, $grandType = null)
    {
        $this->clientId = $clientId ? $clientId : config('auth.client_data.client_id');
        $this->clientSecret = $clientSecret ? $clientSecret : config('auth.client_data.client_secret');
        $this->grandType = $grandType ? $grandType : config('auth.client_data.grand_type');
    }

    /**
     * Метод реализует паттерн Singleton и выдает либо новый объект класса либо уже существующий
     *
     * @param null|string $clientId
     * @param null|string $clientSecret
     * @param null|string $grandType
     *
     * @return RequestPassport
     */
    public static function getInstance($clientId = null, $clientSecret = null, $grandType = null): self
    {
        if (self::$instance) {
            return self::$instance;
        }

        return self::$instance = new self($clientId, $clientSecret, $grandType);
    }


    /**
     * Метод оправляет запрос на аутентификацию пользоателя в системе.
     * При успешном выполеннии запроса возращаетсяя новый access token и refresh token
     *
     * @param string $login
     * @param string $password
     *
     * @return array
     * @throws Exception
     */
    public function sendLogin(string $login, string $password): array
    {
        $passportRequest = Request::create(self::LOGIN_PATH, 'POST', [
            'grant_type' => $this->grandType,
            'username' => $login,
            'password' => $password,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scopes' => '[*]'
        ]);

        $response = app()->handle($passportRequest);

        return $this->formattedResponse($response);
    }

    /**
     * Метод отправляет запрос на перевыпуск нового access token на основе передаваемого refresh token
     *
     * @param string $refreshToken
     *
     * @return array
     * @throws Exception
     */
    public function sendRefresh(string $refreshToken): array
    {
        $passportRequest = Request::create(self::REFRESH_PATH, 'POST', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
            'scopes' => '[*]'
        ]);

        $response = app()->handle($passportRequest);

        return $this->formattedResponse($response);
    }


    /**
     * Метод форматирует запрос и возращает ответ в кооректном виде
     *
     * @param $response
     *
     * @return array
     * @throws Exception
     */
    protected function formattedResponse($response)
    {
        try {
            $json = json_decode($response->getContent(), true);
            return $json;
        } catch (Exception $e) {
            throw new \Exception('Не корректный ответ от сервера');
        }
    }
}
