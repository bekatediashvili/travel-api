<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToursListRequest extends FormRequest
{
    public mixed $dateFrom;


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
            'priceFrom' => 'numeric',
            'priceTo' => 'numeric',
            'dateFrom' => 'date',
            'dateTo' => 'date',
        ];
    }

    public function messages(): array
    {
        return [
            'priceFrom' => 'priceFrom is not Correct',
            'dateFrom' => 'Date is not Valid'
        ];
    }
}
