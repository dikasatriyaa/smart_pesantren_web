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
            'name' => 'required|min:5|max:150',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:5|max:25',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => "Mohon Masukkan Nama Anda",
            'name.min' => "Panjang Nama Minimal 5 Karakter",
            'name.max' => "Panjang Nama Maximal 150 Karakter",
            'email.required' => "Mohon Masukkan Alamat Email",
            'email.email' => "Gunakan Email yang sesuai",
            'email.unique' => "Email telah terdaftar, silahkan gunakan alamat email yang lain",
        ];
    }
}
