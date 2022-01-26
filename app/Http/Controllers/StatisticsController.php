<?php

namespace App\Http\Controllers;

use App\Models\ClosedRate;
use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function potatoIndex(Request $request)
    {
        $id = $request->get('id');

        $potatoes = Selling::query()
            ->when($id, fn($q) => $q->where('sellingable_id', $id))
            ->where("sellingable_type", Potato::class)
            ->with('sellingable')
            ->latest()
            ->get()
            ->groupBy(function ($selling){
                return $selling->sellingable->id;
            });

        return view("Admin.statistics.potatoes.index", compact('potatoes'));
    }
    public function onionIndex(Request $request)
    {
        $id = $request->get('id');

        $onions = Selling::query()
            ->when($id, fn($q) => $q->where('sellingable_id', $id))
            ->where("sellingable_type", Onion::class)
            ->with('sellingable')
            ->latest()
            ->get()
            ->groupBy(function ($selling){
                return $selling->sellingable->id;
            });

        return view("Admin.statistics.onions.index", compact('onions'));
    }

    public function closedRatesIndex(int $id){


        $closed = Selling::query()
            ->where("closed_rate_id", $id)
            ->with('sellingable')
            ->latest('type')
            ->latest()
            ->get()
            ->groupBy(function ($selling){
                return $selling->sellingable_type;
            });

        return view("Admin.statistics.index", compact('closed'));
    }
}
