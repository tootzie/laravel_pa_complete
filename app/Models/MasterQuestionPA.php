<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterQuestionPA extends Model
{
    use HasFactory;
    protected $table = 'master_question_pa';
    protected $guarded = [];

    public function MasterAspek()
    {
        return $this->belongsTo(MasterSubAspek::class, 'id_master_aspek');
    }

    public function DetailPA()
    {
        return $this->hasMany(DetailPA::class, 'id_master_question_pa');
    }
}
