<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Storage;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class EditRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

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
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function rules()
    {
        $rules = [
            'first_name' => 'bail|required|max:128',
            'last_name' => 'bail|required|max:128',
            'email' => 'bail|required|email|max:128',
            'birthday' => 'bail|required|before:-18 years||max:128',
            'avatar' => 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2097152|min:2',
            'address' => 'bail|required|max:256',
            'salary' => 'bail|required|Numeric|digits_between:1,11',
            'gerder' => 'bail|required',
            'status' => 'bail|required',
        ];
        if (request()->hasFile('avatar')) {

            $data = validateImage('avatar');
            session()->put('img_avatar', $data);

        } elseif (request()->get('tmp_url') == "") {
            $data = [
                'src_img' => 'storage/uploads/' . session('employee_edit')->id . '/' . session('employee_edit')->avatar,
                'avatar' => session('employee_edit')->avatar
            ];
            session()->put('img_avatar', $data);
        }

        if (request('password') != null) {
            $rules['password'] = 'required|max:64';
            $rules['password_confirm'] = 'same:password';
            $data['password'] = request('password');
        }

        if (request('email') != session('employee_edit')->email) {
            $rules['email'] = 'bail|required|email|max:128|unique:employees';
        }

        session()->flash('token', request()->get('_token'));
        return $rules;
    }
}
