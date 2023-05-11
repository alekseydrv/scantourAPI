<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
    	'login', 
    	'password', 
    	'tarif',
    	'tourdate_id',
    	'comment',
    	'sngl',
    	'dbl',
    	'twin',
    	'trpl',
    	'qdrpl'
    ];
    
    public function tourists()
    {
         return $this->hasMany(Tourist::class);
    }
}
