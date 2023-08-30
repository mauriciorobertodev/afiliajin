<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PageStoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'             => ['required', 'string', 'min:3', 'max:255'],
            'cloned_from'      => ['required', 'active_url', 'max:255'],
            'slug'             => ['required', 'string', 'min:3', 'max:255'],
        ];
    }
}
