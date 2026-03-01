<?php

namespace App\Http\Requests\Admin;

use App\Enums\OrderStatus;
use App\Enums\PaymentMethod;
use App\Enums\PaymentStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->isAdmin() ?? false;
    }

    public function rules(): array
    {
        return [
            'status'           => ['sometimes', Rule::in(OrderStatus::values())],
            'payment_status'   => ['sometimes', Rule::in(PaymentStatus::values())],
            'payment_method'   => ['sometimes', Rule::in(PaymentMethod::values())],
            'shipping_address' => ['sometimes', 'string', 'max:500'],
            'shipping_phone'   => ['sometimes', 'string', 'max:20'],
            'notes'            => ['nullable', 'string', 'max:1000'],
        ];
    }
}
