<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required|string',
            'genre_id' => 'integer',
            'authors.*' => 'integer', // pour vérifier un tableau d'entiers il faut mettre authors.*
            'status' => 'in:published,unpublished',
            'title_image' => 'string|nullable', // pour le titre de l'image si il existe
            'picture' => 'image|max:3000',
        ];
    }
}
