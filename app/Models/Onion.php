<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Onion extends Model
{
    use HasFactory;
    protected $fillable = ['from_whom', 'car_number', 'driver_name', 'supply_cost','cost', 'type', 'red_bag_number','yellow_bag_number' ,'lom_bag_number'];

}
