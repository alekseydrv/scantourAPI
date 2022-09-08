<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','name','tour_date_id'];
    
    protected $visible = ['id','name','tour_date_id'];
    
    public function tourdate()
    {
        return $this->belongsTo(TourDates::class);
    }
    
    public function accomodations()
    {
        return $this->hasMany(Accomodation::class);
    }
}
