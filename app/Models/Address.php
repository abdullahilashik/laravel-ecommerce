<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'type', 'full_name', 'address_line_1', 'address_line_2',
        'city', 'state', 'postal_code', 'country', 'phone', 'is_default'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
