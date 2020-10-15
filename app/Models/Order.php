<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
    ];

    // Cada pedido pertence a um usuário
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cada pedido tem produtos
    public function orderProducts()
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function formatData(int $data)
    {
        return date('d/m/y - H:i', $data);
    }
}
