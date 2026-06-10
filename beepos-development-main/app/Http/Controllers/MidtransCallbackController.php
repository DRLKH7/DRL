<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class MidtransCallbackController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $notification = $request->all();

            Log::info('Midtrans Notification Received', $notification);

            $serverKey = config('services.midtrans.server_key');
            $orderId = $notification['order_id'] ?? null;
            $statusCode = $notification['status_code'] ?? null;
            $grossAmount = $notification['gross_amount'] ?? null;
            $signatureKey = $notification['signature_key'] ?? null;

            $mySignatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

            if ($signatureKey !== $mySignatureKey) {
                Log::warning('Invalid Midtrans signature', [
                    'order_id' => $orderId,
                    'expected' => $mySignatureKey,
                    'received' => $signatureKey,
                ]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid signature',
                ], 403);
            }

            $transactionStatus = $notification['transaction_status'] ?? null;
            $fraudStatus = $notification['fraud_status'] ?? null;
            $paymentType = $notification['payment_type'] ?? 'qris';

            $order = Pesanan::where('payment_reference', $orderId)->first();

            if (! $order) {
                Log::warning('Order not found for Midtrans callback', ['order_id' => $orderId]);

                return response()->json([
                    'status' => 'error',
                    'message' => 'Order not found',
                ], 404);
            }

            $newStatus = $this->determineOrderStatus($transactionStatus, $fraudStatus);

            if ($newStatus) {
                $oldStatus = $order->status;
                $order->status = $newStatus;
                $order->payment_method = $paymentType;
                $order->save();

                Log::info('Order status updated via Midtrans callback', [
                    'order_id' => $orderId,
                    'pesanan_id' => $order->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                    'transaction_status' => $transactionStatus,
                    'fraud_status' => $fraudStatus,
                ]);

                if ($newStatus === 'paid') {
                    $this->broadcastPaymentSuccess($order, $paymentType);
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Notification processed successfully',
            ], 200);

        } catch (\Exception $e) {
            Log::error('Error processing Midtrans callback', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Internal server error',
            ], 500);
        }
    }

    private function determineOrderStatus($transactionStatus, $fraudStatus)
    {

        if ($transactionStatus == 'capture') {
            if ($fraudStatus == 'accept') {
                return 'paid';
            }
        } elseif ($transactionStatus == 'settlement') {
            return 'paid';
        } elseif ($transactionStatus == 'pending') {
            return 'pending';
        } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
            return 'cancelled';
        }

        return null;
    }

    private function broadcastPaymentSuccess($order, $paymentType)
    {
        try {
            $eventData = [
                'order_id' => $order->id,
                'payment_reference' => $order->payment_reference,
                'total' => $order->total,
                'payment_method' => $paymentType,
                'customer' => $order->customer,
                'timestamp' => now()->toIso8601String(),
            ];

            $cacheKey = 'payment_success_events';
            $events = Cache::get($cacheKey, []);
            $events[] = $eventData;

            if (count($events) > 50) {
                $events = array_slice($events, -50);
            }

            Cache::put($cacheKey, $events, now()->addMinutes(5));

            Log::info('Payment success event broadcasted', [
                'order_id' => $order->id,
                'payment_reference' => $order->payment_reference,
            ]);
        } catch (\Exception $e) {
            Log::error('Error broadcasting payment success', [
                'error' => $e->getMessage(),
            ]);
        }
    }

    public function test(Request $request)
    {
        $orderId = $request->input('order_id');
        $status = $request->input('status', 'settlement');

        if (! $orderId) {
            return response()->json([
                'error' => 'order_id is required',
            ], 400);
        }

        $serverKey = config('services.midtrans.server_key');
        $grossAmount = '50000.00';
        $statusCode = '200';
        $signatureKey = hash('sha512', $orderId.$statusCode.$grossAmount.$serverKey);

        $fakeNotification = [
            'transaction_time' => now()->toIso8601String(),
            'transaction_status' => $status,
            'transaction_id' => $orderId.'-TXN',
            'status_message' => 'Test transaction success',
            'status_code' => $statusCode,
            'signature_key' => $signatureKey,
            'payment_type' => 'qris',
            'order_id' => $orderId,
            'merchant_id' => 'TEST-MERCHANT',
            'gross_amount' => $grossAmount,
            'fraud_status' => 'accept',
            'currency' => 'IDR',
        ];

        return $this->handle(new Request($fakeNotification));
    }

    public function getPaymentEvents(Request $request)
    {
        try {
            $lastEventTime = $request->query('since');
            $cacheKey = 'payment_success_events';
            $events = Cache::get($cacheKey, []);

            if ($lastEventTime) {
                $events = array_filter($events, function ($event) use ($lastEventTime) {
                    return $event['timestamp'] > $lastEventTime;
                });
            }

            return response()->json([
                'status' => 'success',
                'events' => array_values($events),
                'count' => count($events),
            ]);
        } catch (\Exception $e) {
            Log::error('Error fetching payment events', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Failed to fetch payment events',
                'events' => [],
            ], 500);
        }
    }
}
