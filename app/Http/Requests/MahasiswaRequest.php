<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class MahasiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'unit_id' => '',
            'region_id' => '',
            'name' => 'required|string',
            'nim' => 'required|numeric|digits:12',
            'address' => 'nullable',
            'email' => 'required|email',
            'no_hp' => 'nullable|max:13',
            // 'last_edu' => 'required|in:sd,smp,sma,d1,d2,d3,d4,s1,s2,s3',
            'birth_date' => 'nullable|date',
            'valid_date' => 'nullable|string|max:5',
        ];
    }
}
