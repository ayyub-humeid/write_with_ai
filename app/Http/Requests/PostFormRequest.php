<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $postId = $this->route('post');

        return [
            'title' => [
                'required', 
                'string', 
                'max:255',
                \Illuminate\Validation\Rule::unique('posts', 'title')->ignore($postId),
                new \App\Rules\DeniedWordsRule()
            ],
            'content' => ['required', 'string', new \App\Rules\DeniedWordsRule()],
            'category_id' => 'required|exists:categories,id',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'nullable|in:published,draft,archived',
        ];
    }
}