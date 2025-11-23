<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaginationRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string,\Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /** How many items to display per page. */
            'per_page' => 'integer|min:1',

            /** The current page. Starts at one. */
            'page' => 'integer|min:1',

            /** A search query to filter the results. */
            'query' => 'string',
        ];
    }
}
