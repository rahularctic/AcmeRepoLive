<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketPurchased extends Model
{
    protected $table='VIT_TICKET_PURCHASED';

    protected $primaryKey = 'TICKETID';

    public $timestamps = false;
}
