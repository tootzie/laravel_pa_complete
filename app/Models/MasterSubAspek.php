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

    public function MasterQuestionPA() //done
    {
        return $this->hasMany(MasterQuestionPA::class, 'id_master_subaspek');
    }
}
