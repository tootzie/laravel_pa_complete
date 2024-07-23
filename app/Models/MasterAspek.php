<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterAspek extends Model
{
    use HasFactory;
    protected $table = 'master_aspek';
    protected $guarded = [];

    public function MasterSubAspek()
    {
        return $this->hasMany(MasterSubAspek::class, 'id_master_aspek');
    }
}
