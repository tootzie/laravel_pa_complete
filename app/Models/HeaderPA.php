<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeaderPA extends Model
{
    use HasFactory;
    protected $table = 'header_pa';
    protected $guarded = [];

    public function MasterTahunPeriode() //done
    {
        return $this->belongsTo(MasterTahunPeriode::class, 'id_master_tahun_periode');
    }

    public function StatusPenilaian()
    {
        return $this->belongsTo(StatusPenilaian::class, 'id_status_penilaian');
    }

    public function DetailPA()
    {
        return $this->hasMany(DetailPA::class, 'id_header_pa');
    }
}
