<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'Name',
        'user_id',
        'Description',
        'Pricing',
    ];

    public function User(){
        return $this->belongsTo("App\Models\User");
    }
}
