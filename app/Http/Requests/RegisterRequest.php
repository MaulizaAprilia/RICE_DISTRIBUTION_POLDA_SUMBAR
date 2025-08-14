<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'pangkat' => ['required', 'string', 'max:255'],
            'jabatan' => ['required', 'string', 'max:255'],
            'foto_wajah' => ['required', 'image', 'mimes:jpeg,png,jpg,gif','max:10240'],
            'foto_ktp' => ['required', 'image', 'mimes:jpeg,png,jpg,gif','max:10240'],
            'nrp' => ['required', 'digits:8', 'unique:user_profile,nrp'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'polsek_id' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama maksimal :max karakter.',

            'nrp.required' => 'NRP wajib diisi.',
            'nrp.digits' => 'NRP harus terdiri dari tepat 8 digit angka.',
            'nrp.unique' => 'NRP sudah terdaftar.',

            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.string' => 'Jabatan harus berupa teks.',
            'jabatan.max' => 'Jabatan maksimal :max karakter.',

            'pangkat.required' => 'Pangkat wajib diisi.',
            'pangkat.string' => 'Pangkat harus berupa teks.',
            'pangkat.max' => 'Pangkat maksimal :max karakter.',

            'password.required' => 'Kata sandi wajib diisi.',
            'password.string' => 'Kata sandi harus berupa teks.',
            'password.min' => 'Kata sandi minimal :min karakter.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak sesuai.',

            'polsek_id.required' => 'Satker wajib dipilih.',
            
            'foto_ktp.required' => 'Foto ktp wajib di upload.',
            'foto_ktp.image' => 'Foto KTP harus berupa file gambar.',
            'foto_ktp.mimes' => 'Format foto KTP harus jpeg, png, jpg, atau gif.',
            'foto_ktp.max' => 'Ukuran Foto KTP maksimal 10 MB.',

            'foto_wajah.required' => 'Foto wajah wajib di upload.',
            'foto_wajah.image' => 'Foto Wajah harus berupa file gambar.',
            'foto_wajah.mimes' => 'Format foto Wajah harus jpeg, png, jpg, atau gif.',
            'foto_wajah.max' => 'Ukuran Foto Wajah maksimal 10 MB.',

        ];
    }
}
