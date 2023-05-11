<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tourist extends Model
{
    use HasFactory;
    
    protected $table = 'tourists';

    protected $fillable = [
    	'passport', 
    	'mail', 
    	'phone',
    	'name',
    	'category',
    	'birth_date',
    	'order_id'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
