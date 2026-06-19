<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'          => ['required', 'string', 'max:255'],
            'email'         => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'nip'           => ['nullable', 'string', 'max:50'],
            'jenis_kelamin' => ['nullable', 'string', 'in:Laki-laki,Perempuan'],
            'foto'          => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp,gif', 'max:2048'],
        ];
    }

    /**
     * Custom error messages (opsional, lebih ramah pengguna).
     */
    public function messages(): array
    {
        return [
            'name.required'          => 'Nama lengkap wajib diisi.',
            'email.required'         => 'Alamat email wajib diisi.',
            'email.email'            => 'Format email tidak valid.',
            'email.unique'           => 'Email sudah digunakan oleh akun lain.',
            'foto.image'             => 'File harus berupa gambar.',
            'foto.mimes'             => 'Format foto harus JPG, PNG, atau WEBP.',
            'foto.max'               => 'Ukuran foto maksimal 2 MB.',
            'jenis_kelamin.in'       => 'Jenis kelamin tidak valid.',
        ];
    }
}