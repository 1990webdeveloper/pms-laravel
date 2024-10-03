<?php

namespace App\Http\Controllers\Api;

use App\Helpers\AppHelper;
use Illuminate\Http\Request;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Requests\SigninRequest;
use App\Models\Admin\User;
use Illuminate\Support\Facades\File;

class AuthenticationController extends BaseController
{
    use HasApiTokens;

    /**
     * Check user login credentials.
     *
     * This function checks the provided email and password against the authentication system.
     * If the credentials are valid, it returns a success response with the user's associated companies.
     * Otherwise, it returns an error response indicating a login failure.
     *
     * @param  SigninRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function checkLogin(SigninRequest $request)
    {
        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = User::find(auth()->user()->id);
            $companies['companies'] = $user->companies->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'subdomain' => $company->subdomain
                ];
            });
            return $this->sendResponse($companies, __('messages.login_success'));
        }
        return $this->sendError(__('messages.login_error'), 200);
    }

    /**
     * Handle the user login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email:rfc,strict,dns,spoof,filter|exists:users,email',
            'password' => 'required|min:4',
            'subdomain' => 'required|alpha_num|exists:companies,subdomain'
        ]);

        if (auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            $response = [];
            $response = auth()->user()->only(['name', 'email']);
            $subdomain = $request->subdomain;
            $response['token'] =  auth()->user()->createToken('lr-pms', ['subdomain' => $subdomain])->plainTextToken;
            $path = "";
            $checkPath = AppHelper::getUserProfilePath(auth()->user()->uuid, auth()->user()->id);
            if (auth()->user()->profile && File::exists(public_path($checkPath . '/' . auth()->user()->profile))) {
                $path = asset(public_path($checkPath . '/' . auth()->user()->profile));
            } else {
                $path = asset('assets/images/avatar.png');
            }
            $response['user_profile'] = $path;
        }

        if ($response) {
            return $this->sendResponse($response, __('messages.login_success'));
        }
        return $this->sendError(__('messages.login_error'), 200);
    }

    /**
     * Logout the authenticated user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return $this->sendResponse([], 'Logout successfully');
    }
}
