<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code', 'type', 'value', 'min_amount', 'expires_at',
        'usage_limit', 'used_count', 'is_active'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];
}
