<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class InventoryCarUpdateRequest extends FormRequest
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
            'merk_mobil'                    => 'required',
            'type_mobil'                    => 'required',
            'nomor_polisi'                  => 'required',
            'warna_mobil'                   => 'required',
            'nomor_rangka_mobil'            => 'required',
            'nomor_mesin_mobil'             => 'required',
            'tanggal_akhir_pajak_mobil'     => 'required|date',
            'tanggal_akhir_plat_mobil'      => 'required|date',
            'tanggal_penyerahan_mobil'      => 'required|date'
        ];
    }
}
