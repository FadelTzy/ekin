<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\target_semester;

class t_log extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function target()
    {
        return $this->hasOne(target_semester::class, 'id', 'id_target');
    }
}
