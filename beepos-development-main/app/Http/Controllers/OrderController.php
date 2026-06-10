<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index()
    {
        $menus = Menu::with('category')
            ->select(['id', 'name', 'price', 'category_id', 'image_path'])
            ->orderBy('name')
            ->get()
            ->map(function ($m) {
                $cat = strtolower($m->category->name ?? 'lainnya');
                if (! in_array($cat, ['makanan', 'minuman', 'lainnya'])) {
                    $cat = 'lainnya';
                }

                return [
                    'id' => $m->id,
                    'name' => $m->name,
                    'price' => (float) $m->price,
                    'category' => $cat,
                    'image' => $m->image_path ? asset('storage/'.$m->image_path) : null,
                ];
            })->values();

        $recent = Pesanan::with('menu')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($o) {
                return [
                    'id' => $o->id,
                    'name' => $o->menu->name ?? 'Item',
                    'qty' => (int) $o->quantity,
                    'total' => (float) $o->total_price,
                    'status' => $o->status,
                    'at' => optional($o->created_at)->toIso8601String(),
                ];
            });

        return view('admin.pesanan', [
            'products' => $menus,
            'recentOrders' => $recent,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'status' => ['required', 'in:draft,paid,pending,cancelled'],
            'note' => ['nullable', 'string', 'max:255'],
            'customer' => ['nullable', 'string', 'max:255'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.id' => ['required', 'exists:menus,id'],
            'items.*.qty' => ['required', 'integer', 'min:1'],
            'items.*.note' => ['nullable', 'string', 'max:255'],
            'payment_method' => ['nullable', 'in:cash,qris'],
            'cash_received' => ['nullable', 'numeric', 'min:0'],
            'change_amount' => ['nullable', 'numeric', 'min:0'],
            'payment_reference' => ['nullable', 'string', 'max:255'],
        ]);

        $userId = Auth::id() ?? 1;

        $menuPrices = Menu::whereIn('id', collect($data['items'])->pluck('id'))
            ->get(['id', 'price'])
            ->keyBy('id');
        $created = [];
        foreach ($data['items'] as $item) {
            $price = (float) optional($menuPrices->get($item['id']))->price;
            $qty = (int) $item['qty'];
            $total = $price * $qty;
            $disc = $request->discount ?? 0;
            if ($disc > 0 && $disc < $total) {
                $total -= $disc;
            } else {
                $disc = 0;
            }

            $order = new Pesanan;
            $order->order_id = uniqid('ORD-');
            $order->user_id = $userId;
            $order->menu_id = $item['id'];
            $order->quantity = $qty;
            $order->customer = $data['customer'] ?? null;
            $order->note = $item['note'] ?? null;
            $order->total_price = $total;
            $order->discount = $disc;
            $order->status = $data['status'];
            $order->payment_method = $data['payment_method'] ?? null;
            $order->cash_received = $data['cash_received'] ?? null;
            $order->change_amount = $data['change_amount'] ?? null;
            $order->payment_reference = $data['payment_reference'] ?? null;
            $order->save();
            $created[] = $order->id;
        }

        return response()->json(['success' => true, 'count' => count($created), 'ids' => $created]);
    }

    public function recent()
    {
        $recent = Pesanan::with('menu')
            ->latest()
            ->take(20)
            ->get()
            ->map(function ($o) {
                return [
                    'id' => $o->id,
                    'name' => $o->menu->name ?? 'Item',
                    'qty' => (int) $o->quantity,
                    'total' => (float) $o->total_price,
                    'status' => $o->status,
                    'at' => optional($o->created_at)->toIso8601String(),
                ];
            });

        return response()->json($recent);
    }

    public function report()
    {
        return view('admin.report.pesanan');
    }

    public function reportData(Request $request)
    {
        $query = Pesanan::with(['menu.category', 'user']);

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [
                $request->start_date.' 00:00:00',
                $request->end_date.' 23:59:59',
            ]);
        }

        if ($request->status && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->whereHas('menu', function ($q) use ($request) {
                $q->where('name', 'like', '%'.$request->search.'%');
            });
        }

        $statsQuery = clone $query;

        $orders = $query->orderBy('created_at', 'desc')->paginate(20);

        $stats = [
            'total_orders' => $statsQuery->count(),
            'total_revenue' => $statsQuery->sum('total_price'),
            'paid_orders' => (clone $statsQuery)->where('status', 'paid')->count(),
            'draft_orders' => (clone $statsQuery)->where('status', 'draft')->count(),
            'pending_orders' => (clone $statsQuery)->where('status', 'pending')->count(),
        ];

        return response()->json([
            'orders' => $orders,
            'stats' => $stats,
        ]);
    }

    public function export(Request $request)
    {
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;

        $filename = 'laporan-pesanan-'.date('Y-m-d-His').'.xlsx';

        return Excel::download(
            new OrdersExport($startDate, $endDate, $status),
            $filename
        );
    }

    public function allOrders(Request $request)
    {
        $allOrders = Pesanan::with(['menu', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $grouped = $allOrders->groupBy('order_id');

        $orders = $grouped->map(function ($items, $orderId) {
            $firstItem = $items->first();

            $itemsList = $items->map(function ($item) {
                return [
                    'id' => $item->menu_id,
                    'name' => $item->menu->name ?? 'Item',
                    'qty' => $item->quantity,
                    'price' => $item->menu->price ?? 0,
                    'note' => $item->note,
                ];
            })->toArray();

            return [
                'id' => $firstItem->id,
                'order_id' => $orderId,
                'user_id' => $firstItem->user_id,
                'customer' => $firstItem->customer,
                'status' => $firstItem->status,
                'created_at' => $firstItem->created_at,
                'payment_method' => $firstItem->payment_method,
                'cash_received' => $firstItem->cash_received,
                'change_amount' => $firstItem->change_amount,
                'payment_reference' => $firstItem->payment_reference,
                'items' => $itemsList,
                'total_items' => $items->count(),
                'total_quantity' => $items->sum('quantity'),
                'total_price' => $items->sum('total_price'),
                'total_discount' => $items->sum('discount'),
                'user' => $firstItem->user,
            ];
        })->values();

        $page = $request->get('page', 1);
        $perPage = 10;
        $total = $orders->count();
        $lastPage = ceil($total / $perPage);
        $offset = ($page - 1) * $perPage;

        $paginatedOrders = $orders->slice($offset, $perPage)->values();

        return response()->json([
            'data' => $paginatedOrders,
            'current_page' => (int) $page,
            'last_page' => $lastPage,
            'per_page' => $perPage,
            'total' => $total,
            'from' => $offset + 1,
            'to' => min($offset + $perPage, $total),
        ]);
    }

    public function show($id)
    {
        $order = Pesanan::with(['menu', 'user'])->findOrFail($id);

        $allItems = Pesanan::with(['menu'])
            ->where('order_id', $order->order_id)
            ->get();

        $items = $allItems->map(function ($item) {
            return [
                'id' => $item->menu_id,
                'name' => $item->menu->name ?? 'Item',
                'qty' => $item->quantity,
                'price' => $item->menu->price ?? 0,
                'note' => $item->note,
                'total' => $item->total_price,
            ];
        })->toArray();

        return response()->json([
            'id' => $order->id,
            'order_id' => $order->order_id,
            'customer' => $order->customer,
            'status' => $order->status,
            'created_at' => $order->created_at,
            'payment_method' => $order->payment_method,
            'cash_received' => $order->cash_received,
            'change_amount' => $order->change_amount,
            'payment_reference' => $order->payment_reference,
            'user' => $order->user,
            'items' => $items,
            'total_items' => count($items),
            'subtotal' => $allItems->sum(function ($item) {
                return ($item->menu->price ?? 0) * $item->quantity;
            }),
            'total_price' => $allItems->sum('total_price'),
            'discount' => $allItems->sum('discount'),
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $data = $request->validate([
            'status' => ['required', 'in:draft,paid,pending,cancelled'],
        ]);

        $order = Pesanan::findOrFail($id);

        Pesanan::where('order_id', $order->order_id)
            ->update(['status' => $data['status']]);

        return response()->json([
            'success' => true,
            'message' => 'Status berhasil diubah',
            'order' => $order->fresh(),
        ]);
    }
}
