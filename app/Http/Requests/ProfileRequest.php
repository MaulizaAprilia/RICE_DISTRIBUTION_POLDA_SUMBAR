<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nrp' => 'required|string|max:255',
            'pangkat' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'foto_ktp' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'nrp.required' => 'NRP wajib diisi.',
            'nrp.string' => 'NRP harus berupa teks.',
            'nrp.max' => 'NRP maksimal 255 karakter.',
        
            'pangkat.required' => 'Pangkat wajib diisi.',
            'pangkat.string' => 'Pangkat harus berupa teks.',
            'pangkat.max' => 'Pangkat maksimal 255 karakter.',
        
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string' => 'Jabatan harus berupa teks.',
            'jabatan.max' => 'Jabatan maksimal 255 karakter.',
        
            'foto_ktp.image' => 'Foto KTP harus berupa file gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus jpeg, png, jpg, atau gif.',
            'foto_ktp.max' => 'Ukuran Foto KTP maksimal 10 MB.',

        ];
    }
}
