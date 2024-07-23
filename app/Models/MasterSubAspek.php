<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSubAspek extends Model
{
    use HasFactory;
    protected $table = 'master_subaspek';
    protected $guarded = [];

    public function MasterAspek() //done
    {
        return $this->belongsTo(MasterAspek::class, 'id_master_aspek');
    }

    public function MasterPertanyaan() //done
    {
        return $this->hasMany(MasterPertanyaan::class, 'id_master_subaspek');
    }
}
