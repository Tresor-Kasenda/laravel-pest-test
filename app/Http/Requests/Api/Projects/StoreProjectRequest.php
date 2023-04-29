<?php

declare(strict_types=1);

namespace App\Http\Requests\Api\Projects;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Exists;

final class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255'
            ],
            'images' => [
                'required',
                'image',
                'mimes:jpeg,jpg,png,gif',
                'max:2048'
            ],
            'content' => [
                'required',
                'string',
                'max:255'
            ],
            'user_id' => [
                'required',
                'integer',
                new Exists(User::class, 'id')
            ],
        ];
    }
}
