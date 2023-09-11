<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

final class PageUpdateRequest extends FormRequest
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
            'name'                => ['required', 'string', 'min:3', 'max:255'],
            'slug'                => ['required', 'string', 'min:3', 'max:255'],
            'more_18'             => ['required', 'boolean'],
            'whatsapp_show'       => ['required', 'boolean'],
            'whatsapp_number'     => ['required_if:whatsapp_show,true', 'string', 'nullable', 'min:12', 'max:13'],
            'whatsapp_message'    => ['nullable', 'string', 'min:3'],
            'cookie'              => ['nullable', 'url', 'max:255'],
            'head_top'            => ['nullable', 'string'],
            'head_bottom'         => ['nullable', 'string'],
            'body_top'            => ['nullable', 'string'],
            'body_bottom'         => ['nullable', 'string'],
        ];
    }

    public function messages()
    {
        return [
            'whatsapp_number.required_if' => __('app.validations.whatsapp_number_required_if'),
        ];
    }
}
