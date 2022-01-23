<?php

namespace App\Http\Controllers;

use App\Models\ClosedRate;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Selling;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class ClosedSellingController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $filters = $request->only(['type', 'daterange', 'customer']);
        $daterange = array_key_exists('daterange', $filters) ? explode(' - ', $filters['daterange']) : [];
        return view('Admin.closed_sellings.index')->with([
            'closed_rates' => ClosedRate::query()
              ->when(array_key_exists('daterange', $filters), fn ($q) => $q->whereBetween('created_at', [Carbon::parse($daterange[0])->startOfDay(), Carbon::parse($daterange[1])->endOfDay()]))
              ->latest()->paginate(25),
        ]);
    }
}
