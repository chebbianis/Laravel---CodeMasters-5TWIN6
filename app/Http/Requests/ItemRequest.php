<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Autorise tous les utilisateurs
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'regex:/^[A-Za-zÀ-ÿ\s]+$/'],
            'description' => ['required', 'string', 'regex:/^[A-Za-zÀ-ÿ0-9\s.,\'-]+$/'],
            'category_id' => ['required', 'exists:categories,id'],
            'condition' => ['required', 'in:bon,moyen,à réparer'],
            'status' => ['required', 'in:disponible,transformé,recyclé'],
            'image_url' => ['nullable', 'image', 'max:4096'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Le nom est obligatoire.',
            'name.regex' => 'Le nom ne peut contenir que des lettres et des espaces.',
            'name.max' => 'Le nom ne peut dépasser 255 caractères.',
            'description.required' => 'La description est obligatoire.',
            'description.regex' => 'La description contient des caractères non autorisés.',
            'category_id.required' => 'La catégorie est obligatoire.',
            'category_id.exists' => 'La catégorie sélectionnée est invalide.',
            'condition.required' => 'La condition est obligatoire.',
            'condition.in' => 'La condition sélectionnée est invalide.',
            'status.required' => 'Le statut est obligatoire.',
            'status.in' => 'Le statut sélectionné est invalide.',
            'image_url.image' => 'Le fichier doit être une image.',
            'image_url.max' => 'L’image ne peut dépasser 4 Mo.',
        ];
    }
}
