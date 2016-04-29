<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketTransaction extends Model
{
    protected $table='VIT_TICKET_TRANSACTION';

    protected $primaryKey = 'attempt_id';

    public $timestamps = false;

    protected $fillable = [
        'order_id',
        'user_id',
        'tickettype_id',
        'event_id',
        'transaction_id',
        'invoice_id',
        'amount',
        'quantity',
        'result_code',
        'result_msg',
        'currency',
        'time',
        'updated',
    ];
}
