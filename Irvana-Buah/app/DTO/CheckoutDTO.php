<?php

namespace App\DTO;

use App\Http\Requests\Customer\ProcessCheckoutRequest;

readonly class CheckoutDTO
{
    public function __construct(
        public string  $name,
        public string  $email,
        public string  $phone,
        public string  $address,
        public string  $paymentMethod,
        public ?string $notes,
        public ?string $couponCode = null,
        public int     $redeemPoints = 0,
    ) {}

    public static function fromRequest(ProcessCheckoutRequest $request): self
    {
        return new self(
            name:          $request->validated('name'),
            email:         $request->validated('email'),
            phone:         $request->validated('phone'),
            address:       $request->validated('address'),
            paymentMethod: $request->validated('payment_method'),
            notes:         $request->validated('notes'),
            couponCode:    $request->input('coupon_code'),
            redeemPoints:  (int) $request->input('redeem_points', 0),
        );
    }
}
