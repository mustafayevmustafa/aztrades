<?php

namespace App\Models;

use Altek\Accountant\Contracts\Recordable;
use Altek\Eventually\Eventually;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Debt extends Model implements Recordable
{
    use SoftDeletes, \Altek\Accountant\Recordable, Eventually;
}
