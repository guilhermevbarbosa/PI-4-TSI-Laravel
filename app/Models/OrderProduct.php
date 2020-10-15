<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model
{
    use HasFactory;

    // PIVOT TABLE - PRODUTOS DO PEDIDO

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'amount'
    ];

    // Cada item pertence a um pedido
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Cada item tem um produto
    public function product()
    {
        return $this->hasOne(Product::class);
    }
}
