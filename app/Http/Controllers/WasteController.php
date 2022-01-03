<?php

namespace App\Http\Controllers;

use App\Models\Waste;
use Illuminate\Http\Request;

class WasteController extends Controller
{
    public function __invoke()
    {
        return view('Admin.waste.index')->with([
            'waste' => Waste::with('wastable')->latest()->paginate(25)
        ]);
    }
}
