<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Models\t_tahunpegawai;

class Pegawai extends Authenticatable
{
    use Notifiable;
    use HasFactory;
    protected $guarded = [];

    public function hasRole($role)
    {
        if ($role == $this->jenis_kepegawaian) {
            return true;
        }
        return false;
    }
    public function skp()
    {
        return $this->belongsTo(t_tahunpegawai::class, 'id_peg', 'id_peg');
    }
}
