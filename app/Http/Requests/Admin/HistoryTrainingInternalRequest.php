<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class HistoryTrainingInternalRequest extends FormRequest
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
            'tanggal_training_internal'         => 'required|date',
            'jam_training_internal'             => 'required',
            'lokasi_training_internal'          => 'required',
            'materi_training_internal'          => 'required',
            'trainer_training_internal'         => 'required'
        ];
    }
}
