<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExcursionDate;

class Excursion extends Model
{
    use HasFactory;
    
    protected $visible = ['id','name','days','start_place','start_time','link','dates'];
    
    public function excursiondates()
    {
        return $this->hasMany(ExcursionDate::class);
    }
}
