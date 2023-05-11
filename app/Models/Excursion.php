<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ExcursionDate;
  /**
  * @OA\Schema(
  *   title="Excursions schema",
  *    @OA\Property(
  *      property="id",
  *      type="integer",
  *      format="int32",
  *      description="id of excursion
  * "
  *    )
  * )
  */
class Excursion extends Model
{
  
    use HasFactory;
    
    
    private $id;
    
    
    protected $visible = ['id','name','days','start_place','start_time','link','dates'];
    
    public function excursiondates()
    {
        return $this->hasMany(ExcursionDate::class);
    }
}
