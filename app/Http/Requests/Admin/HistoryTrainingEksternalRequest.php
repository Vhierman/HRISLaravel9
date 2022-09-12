<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HistoryTrainingEksternalRequest extends FormRequest
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
            'institusi_penyelenggara_training_eksternal'    => 'required',
            'perihal_training_eksternal'                    => 'required',
            'tanggal_awal_training_eksternal'               => 'required|date',
            'tanggal_akhir_training_eksternal'              => 'required|date',
            'jam_training_eksternal'                        => 'required',
            'lokasi_training_eksternal'                     => 'required',
            'alamat_training_eksternal'                     => 'required'
        ];
    }
}
