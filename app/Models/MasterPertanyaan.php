<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPertanyaan extends Model
{
    use HasFactory;
    protected $table = 'master_pertanyaan';
    protected $guarded = [];

    public function MasterSubAspek() //done
    {
        return $this->belongsTo(MasterSubAspek::class, 'id_master_subaspek');
    }
}
