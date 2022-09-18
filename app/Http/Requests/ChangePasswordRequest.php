<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
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
            'password' => ['required', 'min:8','confirmed'],
        ];

        if (Hash::check($request->current_password, auth()->user()->password)) {
            return back()->with('message','Your Password Has Been Update');
        }
        else{
            throw ValidationException::withMessages([
                'current_password' => 'Your Current Password Does Not Match With Our Record',

            ]);
        }
    }
}
