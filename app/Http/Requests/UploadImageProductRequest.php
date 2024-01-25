<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UploadImageProductRequest extends FormRequest
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
            // Product
            'image' => 'required|file|mimes:png|max:5000',
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
            'image.required' => 'Gambar diperlukan, mohon periksa kembali.',
            'image.file' => 'Gambar harus berupa file, mohon periksa kembali.',
            'image.mimes' => 'Format gambar harus berupa PNG, mohon periksa kembali.',
            'image.max' => 'Ukuran maksimal gambar adalah 5MB, mohon periksa kembali.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Gagal upload foto produk!',
            'data'    => $validator->errors()
        ], 422));
    }
}
