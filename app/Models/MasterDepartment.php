<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterDepartment extends Model
{
    use HasFactory;
    protected $table = 'master_department';
    protected $guarded = [];
}
