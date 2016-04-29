<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model {

    protected $table = 'VIT_EVENT';

    protected $primaryKey = 'EVENTID';

    public $timestamps = false;

   //protected $fillable = ['USERID','USEREMAIL', 'USERNAME','remember_token'];


}
