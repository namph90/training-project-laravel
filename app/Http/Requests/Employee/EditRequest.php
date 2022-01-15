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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function rules()
    {
        $data = array();
        $rules = [
            'first_name' => 'bail|required|max:128',
            'last_name' => 'bail|required|max:128',
            'email' => 'bail|required|email|max:128',
            'birthday' => 'bail|required|before_or_equal:now|max:128',
            'avatar' => 'bail|image|mimes:jpeg,png,jpg,gif,svg|max:2097152|min:2',
            'address' => 'bail|required|max:256',
            'salary' => 'bail|required|Numeric',
            'gerder' => 'bail|required',
            'status' => 'bail|required',
        ];
        if (request()->hasFile('avatar')) {
            session()->put('tmp_url', request()->file('avatar')->getPathname());

            $name = request()->file('avatar')->getClientOriginalName();
            Storage::putFileAs('public/tmp', request()->file('avatar'), $name);
            $data = ['src_img' => "storage/tmp/$name", 'avatar' => $name];
            session()->put('img_avatar', $data);

        } elseif (request()->get('tmp_url') == "") {
            $data = ['src_img' => 'storage/uploads/' . session('old_data')->id . '/' . session('old_data')->avatar, 'avatar' => session('old_data')->avatar];
            session()->put('img_avatar', $data);
        }
        $data = array_merge(session('img_avatar'), request()->except(['avatar', 'password']));

        if (request('password') != null) {
            $rules['password'] = 'required|max:64';
            $rules['password_confirm'] = 'same:password';
            $data['password'] = request('password');
        }

        if(request('email') != session('old_data')->email){
            $rules['email'] = 'bail|required|email|max:128|unique:employees';
        }

        session()->put('data_confirm_edit', $data);
        session()->flash('token', request()->get('_token'));
        return $rules;
    }
}
