<?php

namespace App\Http\Controllers;

use App\Models\Onion;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Admin.index')->with([
            'onions' => Onion::get()
        ]);
    }
}
