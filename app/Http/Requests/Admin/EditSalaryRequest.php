<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EditSalaryRequest extends FormRequest
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
            'gaji_pokok'        => 'required',
            'uang_makan'        => 'required',
            'uang_transport'    => 'required',
            'tunjangan_tugas'   => 'required',
            'tunjangan_pulsa'   => 'required',
            'tunjangan_jabatan' => 'required'
        ];
    }
}
