<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Pegawai;

class Peginfo extends Model
{
    use HasFactory;
    protected $guarded = [];

    public static function sayH($id)
    {
        $user = Pegawai::select('nama')->where('id_peg', $id)->first();
        return $user->nama ?? 'Belum Di Set';
    }
    public static function dataPegawai($id)
    {
        $user = Pegawai::where('id_peg', $id)->first();
        return $user;
    }
}
