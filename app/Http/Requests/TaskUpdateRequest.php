<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'price'       => 'required|numeric|min:0|max:999999',
            'name'        => 'required|string|min:1|max:150',
            'description' => 'required|string|min:1|max:1000',
        ];
    }
}
