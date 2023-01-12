<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

/**
 * Модель пользователя
 *
 * Class User
 *
 * @package App\Models
 *
 * @property string name     Имя пользователя
 * @property string email    Емейл пользователя
 * @property string password Пароль пользователя
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Метод поиска необходимого пользователя
     *
     * @param string $username
     *
     * @return \App\Models\User
     */
    public function findForPassport($username)
    {
        return $this->where('email', $username)->orWhere('name', $username)->first();
    }
}
