<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreCategoryRequest extends FormRequest
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
            'name' => 'required|unique:categories',
            'icon' => 'required|file|mimes:svg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama diperlukan, mohon periksa kembali.',
            'name.unique' => 'Nama sudah digunakan, mohon gunakan nama lain.',
            'icon.required' => 'Icon diperlukan, mohon periksa kembali.',
            'icon.file' => 'Icon harus berupa file, mohon periksa kembali.',
            'icon.mimes' => 'Format icon harus berupa SVG, mohon periksa kembali.',
            'icon.max' => 'Ukuran maksimal icon adalah 2048KB, mohon periksa kembali.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi Gagal.',
            'data'    => $validator->errors()
        ], 422));
    }
}
