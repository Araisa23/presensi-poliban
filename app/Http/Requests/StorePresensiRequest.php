<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePresensiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'latitude' => 'nullable|string',
            'longitude' => 'nullable|string',
            'foto' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'latitude.string' => 'Format latitude tidak valid.',
            'longitude.string' => 'Format longitude tidak valid.',
            'foto.string' => 'Format foto tidak valid.',
        ];
    }
}