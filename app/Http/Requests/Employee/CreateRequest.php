<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        //$data = array();
        $rules = [
            'first_name' => 'bail|required|max:128',
            'last_name' => 'bail|required|max:128',
            'email' => 'bail|required|email|max:128|unique:employees',
            'password' => 'required|max:64',
            'password_confirm' => 'same:password',
            'birthday' => 'bail|required|before_or_equal:now|max:128',
            'address' => 'bail|required|max:256',
            'salary' => 'bail|required|Numeric',
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
