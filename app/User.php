<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
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
     * @param Builder $query
     * @param string|null $firstName
     * @return Builder
     */
    public function scopeFirstName(Builder $query, ? string $firstName): Builder
    {
        if (null !== $firstName) {
            return $this->searchByField($query, 'first_name', "%$firstName%", 'like');
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $lastName
     * @return Builder
     */
    public function scopeLastName(Builder $query, ? string $lastName): Builder
    {
        if (null !== $lastName) {
            return $this->searchByField($query, 'last_name', "%$lastName%", 'like');
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string|null $email
     * @return Builder
     */
    public function scopeEmail(Builder $query, ? string $email): Builder
    {
        if (null !== $email) {
            return $this->searchByField($query, 'email', $email, '=');
        }

        return $query;
    }

    /**
     * @param Builder $query
     * @param string $field
     * @param string $value
     * @param string|null $operator
     * @return Builder
     */
    private function searchByField(Builder $query, string $field, string $value, string $operator = null): Builder
    {
        return $query->where($field, $operator, $value);
    }
}
