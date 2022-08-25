<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Jabatan;
use App\Models\Unit;
use App\Models\Itemtupok;

class Tupoksi extends Model
{
    use HasFactory;
    protected $fillable = ['jab_id', 'unit_id', 'Tahun'];
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
