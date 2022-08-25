<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\t_rbulan;
use App\Models\Manajemen_p;
use App\Models\t_log;

class t_tahunpegawai extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function bulan()
    {
        return $this->hasOne(t_rbulan::class, 'id_mn', 'id');
    }

    public function skp1()
    {
        return $this->hasOne(Manajemen_p::class, 'id', 'id_semester_1');
    }
    public function skp2()
    {
        return $this->hasOne(Manajemen_p::class, 'id', 'id_semester_2');
    }
    public function log1()
    {
        return $this->hasMany(t_log::class, 'id_mn', 'id_semester_1');
    }
    public function log2()
    {
        return $this->hasMany(t_log::class, 'id_mn', 'id_semester_2');
    }
}
