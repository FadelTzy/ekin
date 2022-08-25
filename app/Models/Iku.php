<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iku extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jab_id');
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function item()
    {
        return $this->hasMany(Itemtupok::class, 'jab_id');
    }
}
