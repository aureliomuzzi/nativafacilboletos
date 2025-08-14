<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GetTicket extends Model
{
    use HasFactory;

    public $table = 'get_tickets';
    public $guarded = ['id', 'created_at', 'updated_at'];
}
