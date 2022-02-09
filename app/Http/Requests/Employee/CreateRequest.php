<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Factory as ValidationFactory;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    //protected $stopOnFirstFailure = true;
    public function authorize()
    {
        return true;
    }

    protected $redirectRoute = 'employee.create';

//    public function messages()
//    {
//        return [
//
//            'birthday.before' => 'The Employee must be 18 years old or above.',
//        ];
//    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {//|before_or_equal:now
        $rules = [
            'first_name' => 'bail|required|max:128',
            'last_name' => 'bail|required|max:128',
            'email' => 'bail|required|email|max:128|unique:employees',
            'password' => 'required|max:64',
            'password_confirm' => 'same:password',
            'birthday' => 'bail|required|before:-18 years|max:128',
            'address' => 'bail|required|max:256',
            'salary' => 'bail|required|Numeric|digits_between:1,11',
            'gerder' => 'bail|required',
            'status' => 'bail|required',
        ];
        if (request()->hasFile('avatar')) {
            $data = validateImage('avatar');
            session()->put('img_avatar', $data);
            session()->put('url_img', $data['src_img']);

            $rules['avatar'] = 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2097152|min:2';

        } else if (request()->get('tmp_url') == "") {
            $rules['avatar'] = 'bail|required|image|mimes:jpeg,png,jpg,gif,svg|max:2097152|min:2';

        } else {
            $rules['avatar'] = 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2097152|min:2';

        }
        session()->flash('token', request()->get('_token'));

        return $rules;
    }
}
