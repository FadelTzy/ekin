<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\t_periode;
use App\Models\t_jabatan;
use App\Models\Pegawai;
use App\Models\target_semester;
use App\Models\t_perilaku;
use App\Models\t_nilaitambahan;

class Manajemen_p extends Model
{
    use HasFactory;
    protected $guarded = [''];
    public function periode()
    {
        return $this->belongsTo(t_periode::class, 'id_ped', 'id');
    }
    public function tugasjabatan()
    {
        return $this->belongsTo(t_jabatan::class, 'id_jab', 'id');
    }
    public function datapegawai()
    {
        return $this->hasOne(Pegawai::class, 'id_peg', 'id_peg');
    }
    public function targetsemester()
    {
        return $this->hasOne(target_semester::class, 'id', 'id_ped');
    }
    public function perilaku()
    {
        return $this->hasOne(t_perilaku::class, 'id_m', 'id');
    }
    public function tugastambahan()
    {
        return $this->hasOne(t_nilaitambahan::class, 'id_mn', 'id');
    }
}
