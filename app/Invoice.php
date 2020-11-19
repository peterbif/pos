<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Invoice extends Model
{

    use Notifiable;
    protected $fillable = ['name', 'description', 'amount', 'email', 'charge_id'];
}
