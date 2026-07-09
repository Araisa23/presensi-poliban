<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PegawaiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil ID pegawai yang sedang diedit (kalau route punya parameter {id} atau {pegawai})
        $pegawaiId = $this->route('pegawai') ?? $this->route('id');

        return [

            'nip' => [
                'required',
                'digits:18',              // HARUS TEPAT 18 DIGIT ANGKA
                'numeric',                 // PASTIKAN MURNI ANGKA (bukan huruf/simbol)

                // Cek unique di tabel users, kecuali user milik pegawai yang sedang diedit
                Rule::unique('users', 'nip')->ignore(
                    $pegawaiId ? optional(\App\Models\TenagaKependidikan::find($pegawaiId))->user_id : null
                ),
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'jenis_kelamin' => [
                'required',
                Rule::in(['L', 'P']),
            ],

            'pangkat' => [
                'nullable',
                'string',
                'max:255',
            ],

            'unit_kerja_id' => [
                'required',
                'exists:unit_kerjas,id', // sesuaikan nama tabel jika berbeda
            ],

        ];
    }

    public function messages(): array
    {
        return [
            'nip.required'   => 'NIP wajib diisi.',
            'nip.digits'     => 'NIP harus terdiri dari tepat 18 digit angka.',
            'nip.numeric'    => 'NIP hanya boleh berisi angka.',
            'nip.unique'     => 'NIP ini sudah terdaftar.',

            'nama.required'  => 'Nama wajib diisi.',

            'jenis_kelamin.required' => 'Jenis kelamin wajib dipilih.',
            'jenis_kelamin.in'       => 'Jenis kelamin harus L atau P.',

            'unit_kerja_id.required' => 'Unit kerja wajib dipilih.',
            'unit_kerja_id.exists'   => 'Unit kerja tidak valid.',
        ];
    }
}