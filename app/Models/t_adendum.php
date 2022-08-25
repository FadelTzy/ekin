<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class t_adendum extends Model
{
    use HasFactory;
    protected $fillable = ['keterangan', 'kegiatan', 'bulan', 'satuan', 'kuantitas', 'id_m', 'id_t'];
}
