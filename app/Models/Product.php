<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['name', 'description', 'image', 'price', 'discount', 'stock', 'category_id'];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }
}
