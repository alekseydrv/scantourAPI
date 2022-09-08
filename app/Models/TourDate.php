<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Tour;

class TourDate extends Model
{
    use HasFactory;
    
    protected $visible = ['id','tour_id','tour_date'];
    
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }
    
    public function tariffs()
    {
        return $this->hasMany(Tariff::class);
    }
}
