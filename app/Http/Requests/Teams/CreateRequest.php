<?php

namespace App\Http\Requests\Teams;

use http\Env\Request;
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
        session()->flash('token', request()->get('_token'));
        return [
            'name' => 'bail|required|max:128',
        ];
    }
//    public function withValidator($validator)
//    {
//        //All rules have passed, convert our spatial reference to multiple formats and merge to the request for persisting.
//        if ($validator->fails()) {
//           return back()->with('old', request()->all());
//        }
//    }
}
