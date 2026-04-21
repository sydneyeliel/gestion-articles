<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre'       => ['required', 'string', 'min:3', 'max:100'],
            'description' => ['required', 'string', 'min:10', 'max:2000'],
            'image'       => ['nullable', 'url', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'       => 'Le titre est obligatoire.',
            'titre.min'            => 'Le titre doit contenir au moins :min caractères.',
            'titre.max'            => 'Le titre ne peut pas dépasser :max caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.min'      => 'La description doit contenir au moins :min caractères.',
            'description.max'      => 'La description ne peut pas dépasser :max caractères.',
            'image.url'            => "L'image doit être une URL valide.",
        ];
    }
}