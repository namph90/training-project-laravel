<?php

namespace App\Http\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;

class CreateRequest extends FormRequest
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
     */
    public function rules()
    {//unique:teams
        session()->put('old_value', request()->all());
        session()->flash('token', request()->get('_token'));
        return [
            'name' => 'bail|required|max:128',
        ];
    }
}
