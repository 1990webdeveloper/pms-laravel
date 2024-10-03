<?php

namespace App\Models\Admin;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissionsTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'uuid',
        'email',
        'password',
        'status',
        'profile',
        'phone_no',
        'city',
        'country',
        'birth_date'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * User validation rules
     *
     * @var array
     */
    public static function getCreateValidationRule($userId = null)
    {
        $validation = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns,strict,filter|unique:users,email,' . $userId,
            'phone_no' => 'required|numeric|digits:10',
        ];

        return $validation;
    }

    /**
     * User validation messages
     *
     * @var array
     */
    public static function getCreateValidationMessage()
    {
        $message = [
            'name.required' => 'Please enter a name.',
            'email.required' => 'Please enter a email.',
            'email.email' => 'Please enter valid email.',
            'phone_no.required' => 'Please enter phone number.',
            'phone_no.numeric' => 'Phone number must be numeric',
            'phone_no.digits' => 'Phone number must be 10 digits',
        ];
        return $message;
    }

    /**
     * Get the companies associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function companies()
    {
        return $this->belongsToMany(Company::class, 'users_companies');
    }

    /**
     * Get the roles associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'users_roles');
    }

    /**
     * Check if the model has any of the specified roles.
     *
     * @param  string[]  ...$roles
     * @return bool
     */
    public function hasRole(...$roles)
    {
        foreach ($roles as $role) {
            if ($this->roles->contains('slug', $role)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Get the value of the "role" attribute.
     *
     * @return mixed
     */
    public function getRoleAttribute()
    {
        return $this->roles()->first();
    }
}
