<?php

namespace App\Http\Controllers;

use App\Models\Onion;
use App\Models\Potato;
use App\Models\PotatoSac;
use App\Models\Waste;
use Illuminate\Http\JsonResponse;

class WasteController extends Controller
{
    public function index()
    {
        return view('Admin.waste.index')->with([
            'waste' => Waste::with('wastable')->latest()->paginate(25)
        ]);
    }

    public function destroy(Waste $waste): JsonResponse
    {
        if($waste->delete()){
            switch ($waste->getAttribute('wastable_type')) {
                case Onion::class:
                    if (!is_null($waste->getAttribute('waste_sac_name')) && !is_null($waste->getAttribute('waste_weight'))) {
                        $waste->wastable()->update([
                            'total_weight' =>
                                $waste->getRelationValue('wastable')->getAttribute('total_weight') +
                                $waste->getAttribute('waste_weight'),
                            $waste->getAttribute('waste_sac_name') =>
                                $waste->getRelationValue('wastable')->getAttribute($waste->getAttribute('waste_sac_name')) +
                                $waste->getAttribute('waste_sac_count')
                        ]);
                    } else {
                        if (is_null($waste->getAttribute('waste_sac_name'))) {
                            $waste->wastable()->update([
                                'total_weight' =>
                                    $waste->getRelationValue('wastable')->getAttribute('total_weight') +
                                    $waste->getAttribute('waste_weight')
                            ]);
                        } else {
                            $waste->wastable()->update([
                                $waste->getAttribute('waste_sac_name') =>
                                    $waste->getRelationValue('wastable')->getAttribute($waste->getAttribute('waste_sac_name')) +
                                    $waste->getAttribute('waste_sac_count')
                            ]);
                        }
                    }

                    break;

                case Potato::class:
                    if (!is_null($waste->getAttribute('waste_sac_name')) && !is_null($waste->getAttribute('waste_weight'))) {
                        $waste->wastable()->update([
                            'total_weight' =>
                                $waste->getRelationValue('wastable')->getAttribute('total_weight') +
                                $waste->getAttribute('waste_weight')
                        ]);

                        $sac = PotatoSac::find($waste->getAttribute('waste_sac_name'));
                        $sac_count = $sac->getAttribute('sac_count') + $waste->getAttribute('waste_sac_count');

                        $sac->update([
                            'sac_count' => $sac_count,
                            'total_weight' => $sac_count * $sac->getAttribute('sac_weight')
                        ]);
                    } else {
                        if (is_null($waste->getAttribute('waste_sac_name'))) {
                            $waste->wastable()->update([
                                'total_weight' =>
                                    $waste->getRelationValue('wastable')->getAttribute('total_weight') +
                                    $waste->getAttribute('waste_weight')
                            ]);
                        } else {
                            $sac = PotatoSac::find($waste->getAttribute('waste_sac_name'));
                            $sac_count = $sac->getAttribute('sac_count') + $waste->getAttribute('waste_sac_count');

                            $sac->update([
                                'sac_count' => $sac_count,
                                'total_weight' => $sac_count * $sac->getAttribute('sac_weight')
                            ]);
                        }
                    }

                    break;

            }
            return response()->json(['code' => 200]);
        }else{
            return response()->json(['code' => 400]);
        }
    }
}
