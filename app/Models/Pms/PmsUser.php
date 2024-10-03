<?php

namespace App\Models\Pms;

use App\Permissions\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class PmsUser extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;
    use HasPermissionsTrait;

    protected $table = 'pms_user';

    protected $guard = 'pms_user';

    protected $guarded = ['id'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'profile',
        'phone_no',
        'city',
        'country',
        'birth_date',
        'weekly_limit',
        'additional_info',
        'address',
        'show_rate',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'created_at', 'updated_at'
    ];

    /**
     * Get the password for authentication.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Pms User validation rules
     *
     * @var array
     */
    public static function getCreateValidationRule($userId = null)
    {
        $validation = [
            'name' => 'required',
            'email' => 'required|email:rfc,dns,strict,filter|unique:' .
                (tenant('id') ? 'pms_user' : 'users') . ',email,' . $userId,
            'phone_no' => 'required|numeric|digits:10',
        ];

        return $validation;
    }

    /**
     * Pms User validation message
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
     * Register validation rules
     *
     * @var array
     */
    public static function getRegisterValidationRule()
    {
        $validation = [
            'fname' => 'required|string|min:2|max:30',
            'lname' => 'required|string|min:2|max:30',
            'subdomain' => 'required|alpha_num|unique:companies,subdomain',
            'email' => 'required|string|email:rfc,dns|unique:users,email',
        ];

        return $validation;
    }

    /**
     * Register validation message
     *
     * @var array
     */
    public static function getRegisterValidationMessage()
    {
        $message = [
            'fname.required' => 'Please enter a first name.',
            'fname.min' => 'Minimum 2 character required.',
            'fname.max' => 'Maximum limit is 30 character.',
            'lname.required' => 'Please enter a last name.',
            'lname.min' => 'Minimum 2 character required.',
            'lname.max' => 'Maximum limit is 30 character.',
            'subdomain.required' => 'Please enter a subdomain name.',
            'subdomain.alpha_num' => 'Subdomain must be in alphabet and number.',
            'subdomain.unique' => 'Subdomain is already taken.',
            'email.required' => 'Please enter a email.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'This email is is already registered.',
        ];
        return $message;
    }

    /**
     * Get the roles associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->belongsToMany(PmsRole::class, 'pms_users_roles', 'user_id', 'role_id');
    }

    /**
     * Get the teams associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(PmsTeam::class, 'pms_teams_users', 'user_id', 'team_id');
    }

    /**
     * Get the positions associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function positions()
    {
        return $this->belongsToMany(PmsPosition::class, 'pms_users_positions', 'user_id', 'position_id');
    }

    /**
     * Get the contracts associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contracts()
    {
        return $this->hasMany(PmsContract::class, 'user_id');
    }

    /**
     * Get the tasks associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tasks()
    {
        return $this->belongsToMany(PmsTask::class, 'pms_tasks_users', 'user_id', 'task_id');
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
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
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
