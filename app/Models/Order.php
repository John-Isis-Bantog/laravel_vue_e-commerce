<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['grand_total', 'status', 'user_id',];
    public function user()
    {
        return $this->belongsTo(user::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
