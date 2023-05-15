<?php

namespace App\Models;

use App\Models\Ride;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketSellsReport extends Model
{
    use HasFactory;

    public function ride(){
        return $this->belongsTo(Ride::class, 'ride_id','id');
    }
}
