<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'subdomain',
        'profile',
        'phone_no',
        'city',
        'country',
        'status',
    ];

    /**
     * Company validation rules
     *
     * @var array
     */
    public static function getCreateValidationRule($company)
    {
        $companyId = (isset($company['id'])) ? $company['id'] : '';
        $validation = [
            'name' => 'required',
            'subdomain' => 'required|alpha_num|unique:companies,subdomain,' . $companyId,
            'phone_no' => 'required|numeric|digits:10',
        ];

        if (isset($company['profile']) && !is_string($company['profile'])) {
            $validation = array_merge($validation, ['profile' => 'required']);
        } else {
            $validation = array_merge($validation, ['profile' => 'required']);
        }
        return $validation;
    }

    /**
     * Company validation messages
     *
     * @var array
     */
    public static function getCreateValidationMessage()
    {
        $message = [
            'name.required' => 'Please enter a company name.',
            'subdomain.required' => 'Please enter a domain name.',
            'subdomain.unique' => 'Domain name is already exist.',
            'subdomain.alpha_num' => 'Domain name must only contain alphabets and numeric.',
            'profile.required' => 'Please upload profile image.',
            'profile.mimes' => 'Please upload valid profile image.',
            'phone_no.required' => 'Please enter phone number.',
            'phone_no.numeric' => 'Phone number must be numeric',
            'phone_no.digits' => 'Phone number must be 10 digits',
        ];
        return $message;
    }

    /**
     * Get the users associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'users_companies');
    }
}
