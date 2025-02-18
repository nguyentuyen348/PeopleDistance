<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $primaryKey = "registerID";
    protected $table = "accounts";
    protected $fillable = ['login','password','phone'];
    public $timestamps = false;
}
