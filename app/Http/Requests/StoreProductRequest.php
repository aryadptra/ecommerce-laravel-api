<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProductRequest extends FormRequest
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
            'category_id' => 'required',
            'description' => 'required',
            'thumbnail' => 'required|file|mimes:png|max:5000',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            // Product details
            'product_id' => 'required',
            'size' => 'required|numeric',
            'color' => 'required',
            'weight' => 'required|numeric',
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
            'category_id.required' => 'Kategori diperlukan, mohon periksa kembali.',
            'name.required' => 'Nama produk diperlukan, mohon periksa kembali.',
            'description.required' => 'Deskripsi diperlukan, mohon periksa kembali.',
            'thumbnail.required' => 'Thumbnail diperlukan, mohon periksa kembali.',
            'thumbnail.file' => 'Thumbnail harus berupa file, mohon periksa kembali.',
            'thumbnail.mimes' => 'Format thumbnail harus berupa SVG, mohon periksa kembali.',
            'thumbnail.max' => 'Ukuran maksimal icon adalah 5MB, mohon periksa kembali.',
            'price.required' => 'Harga diperlukan, mohon periksa kembali.',
            'stock.required' => 'Thumbnail diperlukan, mohon periksa kembali.',

            // Product details
            'product_id.required' => 'Id Produk diperlukan, mohon periksa kembali.',
            'size.required' => 'Ukuran diperlukan, mohon periksa kembali.',
            'color.required' => 'Warna diperlukan, mohon periksa kembali',
            'weight.required' => 'Berat diperlukan, mohon periksa kembali',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Gagal membuat produk!',
            'data'    => $validator->errors()
        ], 422));
    }
}
