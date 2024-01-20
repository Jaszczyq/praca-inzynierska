<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';

    protected $fillable = [
        'event_id',
        'seat'
    ];

    public function event() {
        return $this->belongsTo(Event::class);
    }

    public function isCancelled() {
        return $this->deleted_at !== null;
    }
}
