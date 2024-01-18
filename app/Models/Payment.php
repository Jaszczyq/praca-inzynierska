<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';

    protected $fillable = [
        'user_id',
        'item_name',
        'amount',
        'currency_id',
        'method_id',
        'status',
        'transaction_id',
        'details'
    ];

    protected $casts = [
        'details' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function currency()
    {
        return DB::table('payments_currencies')->where('id', $this->currency_id)->first();
    }

    public function method()
    {
        return DB::table('payments_methods')->where('id', $this->method_id)->first();
    }

    public function status()
    {
        return DB::table('payments_statuses')->where('id', $this->status)->first();
    }
}
