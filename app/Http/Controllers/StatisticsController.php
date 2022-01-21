<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\ExpensesType;
use App\Models\Onion;
use App\Models\Potato;
use App\Models\Selling;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function potatoIndex(){

        $potatoes = Selling::where("sellingable_type", Potato::class)->with('sellingable')->latest()->get()
            ->groupBy(function ($selling){
                return $selling->sellingable->info;
            });

        return view("Admin.statistics.potatoes.index", compact('potatoes'));
    }
    public function onionIndex(){

        $onions = Selling::where("sellingable_type", Onion::class)->with('sellingable')->latest()->get()
            ->groupBy(function ($selling){
                return $selling->sellingable->info;
            });

        return view("Admin.statistics.onions.index", compact('onions'));
    }

    public function closedRatesIndex(int $id){

        $closed = Selling::where("closed_rate_id", $id)
            ->with('sellingable')->latest()->get()
            ->groupBy(function ($selling){
                return $selling->sellingable->info;
            });

        return view("Admin.statistics.index", compact('closed'));
    }
}
