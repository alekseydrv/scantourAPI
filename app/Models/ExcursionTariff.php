<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
  * @OA\Schema(
  *   title="Excursion's tariff schema",
  *    @OA\Property(
  *      property="availability",
  *      type="integer",
  *      format="int32",
  *      description="2 - Много мест, 1 - По запросу, 0 - нет мест"
  * 
  *    )
  * )
  */

class ExcursionTariff extends Model
{
    use HasFactory;
    
    protected $fillable = ['id','name','excursion_date_id', 'price', 'availability', 'updated_at'];
    
    protected $visible = ['id','name','excursion_date_id', 'price', 'availability', 'updated_at'];
    
    public function excursiondates()
    {
        return $this->belongsTo(ExcursionDate::class);
    }
}
