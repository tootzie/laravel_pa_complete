<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterTahunPeriode extends Model
{
    use HasFactory;
    protected $table = 'master_tahun_periode';
    protected $guarded = [];

    public function HeaderPA()
    {
        return $this->hasMany(HeaderPA::class, 'id_master_tahun_periode');
    }
}
