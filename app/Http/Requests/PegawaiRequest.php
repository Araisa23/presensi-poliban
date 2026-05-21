<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PegawaiRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $pegawaiId = $this->route('pegawai');

        return [
            'nip' => 'required|string|unique:tenaga_kependidikans,nip,' . $pegawaiId,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'pangkat' => 'nullable|string|max:255',
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
        ];
    }
}