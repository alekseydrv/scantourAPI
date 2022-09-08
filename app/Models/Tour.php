<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TourDate;
use OpenApi\Annotations as OA;


class Tour extends Model
{
    use HasFactory;
    
    protected $visible = ['id','name','days','start_place','start_time','link','dates'];
    
    public function tourdate()
    {
        return $this->hasMany(TourDate::class);
    }
}
