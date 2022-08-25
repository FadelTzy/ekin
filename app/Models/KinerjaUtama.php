<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KinerjaUtama extends Model
{
    protected $guarded = [];
    use HasFactory;
    public function target()
    {
        return $this->hasMany(target_semester::class, 'id', 'id_rencana');
    }
}
