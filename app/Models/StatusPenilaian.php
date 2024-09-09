<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPenilaian extends Model
{
    use HasFactory;
    protected $primaryKey = 'kode_status';
    protected $table = 'status_penilaian';
    protected $guarded = [];


    public function HeaderPA()
    {
        return $this->hasMany(HeaderPA::class, 'id_status_penilaian');
    }
}
