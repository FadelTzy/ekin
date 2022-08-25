<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Itemikudosen extends Model
{
    use HasFactory;
    use HasFactory;
    public $timestamps = false;

    protected $fillable = ['item'];
}
