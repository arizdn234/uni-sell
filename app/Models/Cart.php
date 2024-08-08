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
            \Log::info('Deleting cart and its items:', ['cart_id' => $cart->id]);
            $cart->items()->delete();
        });
    }
}
