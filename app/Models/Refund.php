<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Refund extends Model
{
    use HasFactory;

    protected $table = 'refunds';

    protected $fillable = [
        'ticket_id',
        'created_at',
        'updated_at'
    ];

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
