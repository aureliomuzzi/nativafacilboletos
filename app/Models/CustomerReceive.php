<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerReceive extends Model
{
    use HasFactory;

    public $table = 'customers_receive';
    public $guarded = ['id', 'created_at', 'updated_at'];
}
