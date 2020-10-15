<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'amount'
    ];

    // Cada carrinho pode ter 1 usuário
    // Retorno do Usuário daquele carrinho
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Cada linha do carrinho pertence a um produto
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
