<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketType extends Model
{
    protected $table='VIT_TICKETTYPE';

    protected $primaryKey = 'TICKETTYPEID';

    public $timestamps = false;

    protected $fillable = [
        'TICKETCUID',
        'EVENTID',
        'TICKETTYPENAME',
        'TICKETTYPEDESCRIPTION',
        'TICKETPRICE',
        'TICKETMIN',
        'TICKETMAX',
        'TICKETSTARTSALES',
        'TICKETENDSALES',
        'TICKETTOTAL',
        'TICKETREMAINING',
        'TICKETRESERVED'
    ];

}
