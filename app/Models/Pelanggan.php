<?php

namespace App\Models;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pelanggan extends Authenticatable
{
    use HasFactory;
    protected $table = 'users';
    protected $fillable = ['name', 'email', 'password', 'level'];
}
