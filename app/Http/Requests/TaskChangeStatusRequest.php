<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskChangeStatusRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (auth()->user()->is_admin) {
            $rules = [
                'status' => 'required|numeric|in:2,4'
            ];
        } else {
            $rules = [
                'status' => 'required|numeric|in:2,3'
            ];
        }

        return $rules;
    }
}
