<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePajakRequest extends FormRequest
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
    {
        return [
            'item_id' => 'required',
            'name' => 'required',
            'rate' => 'required|max:5',
        ];
    }

    public function messages()
    {
        return [
            'item_id.required' => 'Item wajib diisi',
            'name.required' => 'Nama item wajib diisi',
            'rate.required' => 'Rate wajib diisi',
            'rate.max' => 'Rate maksimal 5 karakter',
        ];
    }
}
