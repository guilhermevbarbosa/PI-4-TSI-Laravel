<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = ['cep', 'h_address', 'h_number', 'neighborhood', 'city', 'state', 'user_id'];

    public function User()
    {
        return $this->hasOne(User::class);
    }
}
