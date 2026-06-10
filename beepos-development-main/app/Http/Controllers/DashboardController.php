<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function admin()
    {
        $orderCount = Pesanan::where('status', 'paid')->count();
        $raw_income = Pesanan::where('status', 'paid')->sum('total_price');
        $raw_disc = Pesanan::where('status', 'paid')->sum('discount');
        $income = $raw_income - $raw_disc;
        $averageTransaction = $orderCount > 0 ? $income / $orderCount : 0;
        if (Auth::check()) {
            if (Auth::user()->role === 'admin') {
                return view('dashboard.admin', compact('income', 'orderCount', 'averageTransaction'));
            } else {
                return redirect()->route('dashboard.user');
            }
        }

        return view('dashboard.admin', compact('income', 'orderCount', 'averageTransaction'));
    }

    public function user()
    {
        return view('dashboard.user');
    }

    public function index()
    {

        return view('dashboard.admin');
    }

    public function stats(Request $request)
    {
        $orderCount = Pesanan::where('status', 'paid')->count();
        $raw_income = Pesanan::where('status', 'paid')->sum('total_price');
        $raw_disc = Pesanan::where('status', 'paid')->sum('discount');
        $income = $raw_income - $raw_disc;
        $averageTransaction = $orderCount > 0 ? $income / $orderCount : 0;

        $recentOrders = Pesanan::with('menu')
            ->where('status', 'paid')
            ->latest()
            ->take(10)
            ->get()
            ->map(function ($order) {
                return [
                    'id' => $order->id,
                    'invoice' => 'INV-'.str_pad($order->id, 4, '0', STR_PAD_LEFT),
                    'time' => $order->created_at->format('H:i'),
                    'table' => 'A'.rand(1, 10),
                    'items' => 1,
                    'total' => (float) $order->total_price,
                    'status' => $order->status,
                ];
            });

        return response()->json([
            'income' => $income,
            'orderCount' => $orderCount,
            'averageTransaction' => $averageTransaction,
            'occupancy' => rand(60, 85),
            'recentOrders' => $recentOrders,
        ]);
    }
}
