<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExcursionTariff extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','name','excursion_date_id', 'price', 'availability'];
    
    protected $visible = ['id','name','excursion_date_id', 'price', 'availability'];
    
    public function excursiondates()
    {
        return $this->belongsTo(ExcursionDate::class);
    }
}
