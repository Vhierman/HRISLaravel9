<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SsEksternalUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'employees_id'          => 'required',
            'tema_ss_eksternal'     => 'required',
            'tanggal_ss_eksternal'  => 'required|date',
            'instansi'              => 'required',
            'edit_oleh'             => 'required'
        ];
    }
}
