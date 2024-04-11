<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'start_date',
        'end_date',
        'status', // Active, Cancelled, etc.
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function subscriptions()
    {
        return $this->belongsTo(User::class);
    }

    

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
