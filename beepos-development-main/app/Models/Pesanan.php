<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    //
    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'menu_id',
        'order_id',
        'quantity',
        'discount',
        'customer',
        'note',
        'total_price',
        'status',
        'payment_method',
        'cash_received',
        'change_amount',
        'payment_reference',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }
}
