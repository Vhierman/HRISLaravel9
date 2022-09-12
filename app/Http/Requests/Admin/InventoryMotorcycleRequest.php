<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InventoryMotorcycleRequest extends FormRequest
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
            'employees_id'                  => 'required',
            'merk_motor'                    => 'required',
            'type_motor'                    => 'required',
            'nomor_polisi'                  => 'required',
            'warna_motor'                   => 'required',
            'nomor_rangka_motor'            => 'required',
            'nomor_mesin_motor'             => 'required',
            'tanggal_akhir_pajak_motor'     => 'required|date',
            'tanggal_akhir_plat_motor'      => 'required|date',
            'tanggal_penyerahan_motor'      => 'required|date',
            'foto_stnk_motor'               => 'required|image|max:512',
            'foto_motor'                    => 'required|image|max:512'
        ];
    }
}
