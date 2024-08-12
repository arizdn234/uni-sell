<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($cart) {
            $cart->items()->delete();
        });
    }

    public function total()
    {
        return $this->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
    }
}
