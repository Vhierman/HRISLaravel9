<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RekapOvertimePkwtHarianRequest extends FormRequest
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
            'status_kerja'      => 'required',
            'golongan'          => 'required',
            'awal'              => 'required|date',
            'akhir'             => 'required|date'
        ];
    }
}
