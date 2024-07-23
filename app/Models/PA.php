<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PA extends Model
{
    use HasFactory;
    protected $table = 'pa';
    protected $guarded = [];

    public function MasterDepartment()
    {
        return $this->belongsTo(MasterDepartment::class, 'id_master_department');
    }

    public function MasterPertanyaan()
    {
        return $this->belongsTo(MasterPertanyaan::class, 'id_master_pertanyaan');
    }
}
