<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory;

    public $table = 'clients';
    public $guarded = ['id', 'created_at', 'updated_at'];
}
