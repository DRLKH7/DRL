<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    //
    protected $table = 'menus';

    protected $fillable = [
        'name',
        'category_id',
        'description',
        'price',
        'stock',
        'image_path',
        'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
