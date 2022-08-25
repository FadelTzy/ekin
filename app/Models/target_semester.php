<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\t_adendum;

class target_semester extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function tupoksi()
    {
        return $this->belongsTo(t_tupoksi::class, 'id_tup', 'id');
    }
    public function adendum()
    {
        return $this->hasOne(t_adendum::class, 'id_t', 'id');
    }
}
