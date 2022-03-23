<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelPayment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'amount',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function payment_approval(): HasOne
    {
        return $this->hasOne(PaymentApproval::class);
    }
}
