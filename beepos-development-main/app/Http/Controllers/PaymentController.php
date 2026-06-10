<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    public function createCharge(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'order_id' => 'required|string',
            'first_name' => 'nullable|string',
            'last_name' => 'nullable|string',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
        ]);

        $params = [
            'transaction_details' => [
                'order_id' => $validated['order_id'],
                'gross_amount' => (int) $validated['amount'],
            ],
            'customer_details' => [
                'first_name' => $validated['first_name'] ?? 'Customer',
                'last_name' => $validated['last_name'] ?? '',
                'email' => $validated['email'] ?? 'customer@example.com',
                'phone' => $validated['phone'] ?? '08123456789',
            ],
            'enabled_payments' => [
                'qris',
                'other_qris',
                'gopay',
                'shopeepay',
                'dana',
                'ovo',
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);

            return response()->json($snapToken);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to create payment',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
