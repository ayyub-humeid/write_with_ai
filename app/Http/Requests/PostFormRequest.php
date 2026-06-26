<?php

namespace App\Http\Requests;

use App\Rules\DeniedWordsRule;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
                $postId ? 'sometimes' : 'required',
                'string',
                'max:255',
                Rule::unique('posts', 'title')->ignore($postId),
                new DeniedWordsRule(),
                'tags'=>['nullable','string']
            ],
            'content' => [$postId ? 'sometimes' : 'required','string', new DeniedWordsRule()],
            'category_id' => [$postId ? 'sometimes' : 'required','exists:categories,id'],
            // 'cover_image' => [$postId ? 'sometimes' : 'required','image|mimes:jpeg,png,jpg,gif,webp|max:5120'],
            // 'status' => [$postId ? 'sometimes' : 'required','in:published,draft,archived'],
            'cover_image'=>'nullable'
        ];
    }
}