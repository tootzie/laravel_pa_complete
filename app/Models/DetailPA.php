<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPA extends Model
{
    use HasFactory;
    protected $table = 'detail_pa';
    protected $guarded = [];

    public function HeaderPA()
    {
        return $this->belongsTo(HeaderPA::class, 'id_header_pa');
    }

    public function MasterQuestionPA()
    {
        return $this->belongsTo(MasterQuestionPA::class, 'id_master_question_pa');
    }


}
