<?php

namespace App\Http\Controllers;

use App\Models\Continent;
use App\Models\Country;
use App\Models\Event;
use App\Models\News;
use App\Models\University;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('index');
    }
}
