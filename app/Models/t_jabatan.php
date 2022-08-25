<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\t_tupoksi;

class t_jabatan extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function item()
    {
        return $this->hasMany(t_tupoksi::class, 'id_jab');
    }
}
