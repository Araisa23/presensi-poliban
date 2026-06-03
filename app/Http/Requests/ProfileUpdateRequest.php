<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'nip' => ['nullable', 'string', 'max:50'],
            'jenis_kelamin' => ['nullable', 'string'],

            'foto' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,jfif,webp',
                'max:2048',
            ],
        ];
    }
}