<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\target_semester;

class t_tupoksi extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function targets()
    {
        return $this->hasMany(target_semester::class, 'id_tup', 'id');
    }
}
