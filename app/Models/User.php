<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Laravel\Cashier\Billable;
use Bavix\Wallet\Traits\HasWallet;
use Bavix\Wallet\Traits\HasWallets;
use Bavix\Wallet\Interfaces\Wallet;

class User extends Authenticatable implements Wallet {
    use Notifiable,
        Billable,
        HasWallet,
        HasWallets;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'avatar',
        'admin',
        'manager',
        'is_seller',
        'credits'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
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
     * Преобразует дату и время регистрации пользователя из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getCreatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

    /**
     * Преобразует дату и время обновления пользователя из UTC в Europe/Moscow
     *
     * @param $value
     * @return \Carbon\Carbon|false
     */
    public function getUpdatedAtAttribute($value) {
        return Carbon::createFromFormat('Y-m-d H:i:s', $value)->timezone('Europe/Moscow');
    }

    /**
     * Связь «один ко многим» таблицы `users` с таблицей `orders`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders() {
        return $this->hasMany(Order::class);
    }

    /**
     * Связь «один ко многим» таблицы `users` с таблицей `profiles`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profiles() {
        return $this->hasMany(Profile::class);
    }

    public function sendPasswordResetNotification($token) {
        $notification = new ResetPassword($token);
        $notification->createUrlUsing(function ($user, $token) {
            return url(route('user.password.reset', [
                'token' => $token,
                'email' => $user->email
            ]));
        });
        $this->notify($notification);
    }

    /**
     * Связь «один ко многим» таблицы `users` с таблицей `wallet`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    // public function wallet() {
    //     return $this->hasMany(Wallets::class);
    // }

    /**
     * Связь «один ко многим» таблицы `users` с таблицей `collections`
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function collections() {
        return $this->hasMany(Collection::class);
    }

    /**
     * Get the activities for the user
     *
     * @return HasMany
     */
    public function activities(): HasMany
    {
        return $this->hasMany(Activity::class);
    }

    public function getReferrals()
    {
        return ReferralProgram::all()->map(function ($program) {
            return ReferralLink::getReferral($this, $program);
        });
    }

    public static function addCredits($user_id, $tokens)
    {
        $tokens = User::find($user_id)->credits + $tokens;
        return User::find($user_id)->update([
            'credits' => $tokens
        ]);
    }
}
