<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ListingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'beds' => ['required', 'integer', 'min:0'],
            'baths' => ['required', 'integer', 'min:0'],
            'area' => ['required', 'integer', 'min:2'],
            'city' => ['required', 'string'],
            'code' => ['required', 'string', 'regex:/^[0-9]{2}-[0-9]{3}$/'],
            'street' => ['required', 'string'],
            'street_nr' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:1']
        ];
    }
}