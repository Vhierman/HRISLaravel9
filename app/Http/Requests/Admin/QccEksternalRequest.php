<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class QccEksternalRequest extends FormRequest
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
            'employees_id'                      => 'required',
            'nama_group_qcc_eksternal'          => 'required',
            'tema_qcc_eksternal'                => 'required',
            'circle_leader_qcc_eksternal'       => 'required',
            'tanggal_konvensi_qcc_eksternal'    => 'required|date',
            'instansi'                          => 'required',
            'input_oleh'                        => 'required'
        ];
    }
}
