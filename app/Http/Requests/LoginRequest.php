<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Factory as ValidationFactory;


class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param ValidationFactory $validationFactory
     */
    protected $stopOnFirstFailure = true;

    public function __construct(ValidationFactory $validationFactory)
    {
        $validationFactory->extend(
            'check_login',
            function ($value) {
                if (!Auth::attempt(['email' => request('email'), 'password' => request('password')])) {
                    return 'check_login' === $value;
                }
            },
            'The password or email entered is incorrect. Forgot password?!'
        );

    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [

            'password.required' => 'The email and password field is required.',
            'email.required' => 'The email and password field is required.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required',
            'password' => 'required|check_login',
        ];
    }
}
