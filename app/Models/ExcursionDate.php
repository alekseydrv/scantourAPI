<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Excursion;
use App\Models\ExcursionTariff;

class ExcursionDate extends Model
{
    use HasFactory;
    
    protected $visible = ['id','excursion_id','excursion_date'];
    
    public function excursion()
    {
        return $this->belongsTo(Excursion::class);
    }
    
    public function excursiontariffs()
    {
        return $this->hasMany(ExcursionTariff::class);
    }
}
