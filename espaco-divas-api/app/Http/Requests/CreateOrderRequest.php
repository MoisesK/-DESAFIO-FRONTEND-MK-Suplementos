<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'productId' => 'required|integer',
            'customer' => 'required|array',
            'customer.name' => 'required|string',
            'customer.email' => 'required|email:rfc',
            'customer.phone' => 'required|string',
            'schedule' => 'required|array',
            'schedule.date' => 'required|date_format:Y-m-d H:i',
            'schedule.paymentProof' => 'required|file',
        ];
    }
}
