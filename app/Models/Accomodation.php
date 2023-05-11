<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accomodation extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','name','tariff_id', 'price', 'availability', 'updated_at'];
    
    protected $visible = ['id','name','tour_date_id', 'price', 'availability', 'updated_at'];
    
    public function tariffs()
    {
        return $this->belongsTo(Tariff::class);
    }
}
