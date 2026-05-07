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
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'foto' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'latitude.required' => 'Lokasi latitude tidak ditemukan.',
            'longitude.required' => 'Lokasi longitude tidak ditemukan.',
            'foto.required' => 'Foto presensi diperlukan.',
        ];
    }
}
