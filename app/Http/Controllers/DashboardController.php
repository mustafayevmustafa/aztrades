<?php

namespace App\Http\Controllers;

use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Admin.index')->with([
            'onions' => Onion::notTrash()->hasWeight()->limit(5)->get(),
            'potatoes' => Potato::notTrash()->hasWeight()->limit(5)->get(),
            'selling' => Selling::get(),
        ]);
    }
}
