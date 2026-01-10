<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['grand_total', 'status', 'user_id',];
    public function orders()
    {
        return $this->belongsTo(User::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
