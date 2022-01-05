<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model implements Recordable
{
    use \Altek\Accountant\Recordable;

    protected $fillable = ['is_active'];

    protected $casts = ['is_active' => 'boolean'];
}
