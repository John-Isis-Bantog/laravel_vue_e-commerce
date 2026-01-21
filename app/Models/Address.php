<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $fillable = ['user_id', 'recipient_name', 'phone', 'city', 'address_line_1', 'address_line_2', 'province', 'postal_code', 'is_default'];
}
