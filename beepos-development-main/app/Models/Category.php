<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Str;

class Category extends Model
{
    //
    protected $fillable = [
        'name',
        'description',
        'slug',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }
}
