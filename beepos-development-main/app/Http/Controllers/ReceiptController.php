<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class ReceiptController extends Controller
{
    public function show($orderId)
    {
        $order = Pesanan::with(['menu', 'user'])->findOrFail($orderId);

        $relatedOrders = Pesanan::with(['menu', 'user'])
            ->where('order_id', $order->order_id)
            ->orWhere(function ($q) use ($order) {
                $q->where('user_id', $order->user_id)
                    ->whereBetween('created_at', [
                        $order->created_at->subSeconds(5),
                        $order->created_at->addSeconds(5),
                    ])
                    ->where('status', $order->status);
            })
            ->get();

        $items = $relatedOrders->map(function ($o) {
            return (object) [
                'name' => $o->menu->name ?? 'Item',
                'qty' => $o->quantity,
                'price' => $o->menu->price ?? 0,
                'note' => $o->note,
            ];
        });

        $orderData = (object) [
            'number' => $order->order_id,
            'order_id' => $order->order_id,
            'created_at' => $order->created_at,
            'cashier_name' => $order->user->name ?? 'Kasir',
            'table_number' => null,
            'customer' => $order->customer,
            'items' => $items,
            'subtotal' => $relatedOrders->sum('total_price'),
            'tax' => 0,
            'service' => 0,
            'discount' => $relatedOrders->sum('discount'),
            'grand_total' => $relatedOrders->sum('total_price'),
            'total_price' => $relatedOrders->sum('total_price'),
            'paid' => $order->cash_received,
            'cash_received' => $order->cash_received,
            'change' => $order->change_amount,
            'change_amount' => $order->change_amount,
            'payment_method' => $order->payment_method ?? 'cash',
            'payment_reference' => $order->payment_reference,
        ];

        $restaurant = [
            'name' => config('app.name', 'BeePOS'),
            'address' => 'Jl. Dr. Ir. H.Juanda No.193, Bandung',
            'phone' => '0812-3456-7890',
            'receipt_id' => 'RCPT-'.date('Y-m-d').'-'.str_pad($orderId, 4, '0', STR_PAD_LEFT),
            'logo' => 'assets/img/struk_logo.png',
        ];

        return view('receipt', ['order' => $orderData, 'restaurant' => $restaurant]);
    }
}
