<?php

namespace App\Observers;

use App\Http\Requests\SellingsRequest;
use App\Models\Selling;

class SellingObserver
{
    protected SellingsRequest $request;

    public function __construct(SellingsRequest $request)
    {
        $this->request = $request;
    }

    public function creating(Selling $selling)
    {
        $validated = $this->request->validated();

        $sellingable = $selling->getRelationValue('sellingable'); // sellingable morph of the selling model

        $error = false;

        if($validated['sac_count'] > 0) {
            switch ($sellingable->getTable()) {
                case 'onions':
                    if ($sellingable->getAttribute($validated['sac_name']) < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    $sellingableData = [
                        'total_weight' => $sellingable->getAttribute('total_weight') - $validated['weight'],
                        $validated['sac_name'] => $sellingable->getAttribute($validated['sac_name']) - $validated['sac_count']
                    ];

                    $selling->sellingable()->update($sellingableData);
                    break;

                case 'potatoes':
                    $sac = $sellingable->sacs()->where('potato_id', $validated['type_id'])->where('name', $validated['sac_name'])->first();

                    if ($sac->getAttribute('sac_count') < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    $sac->update([
                        'sac_count' => $sac->sac_count - $validated['sac_count'],
                        'sac_weight' => $sac->sac_weight - $validated['weight'],
                    ]);
                    break;
            }
        }

        if ($error) {
            return back()->with('message', 'Seçdiyiniz kisədə o qədər say mövcud deyil');
        }

        $selling->saveQuietly();
    }

    public function updating(Selling $selling) {
        $validated = $this->request->validated();

        $sellingable = $selling->getRelationValue('sellingable'); // sellingable morph of the selling model

        $error = false;

        if($selling->getAttribute('sac_count') != $validated['sac_count'] && $validated['sac_count'] > 0) {
            switch ($sellingable->getTable()) {
                case 'onions':
                    if ($sellingable->getAttribute($validated['sac_name']) < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    if($selling->getAttribute('sac_name') != $validated['sac_name']) {
                        $selling->sellingable()->update([
                            'total_weight' => $sellingable->getAttribute('total_weight') + $selling->getAttribute('weight'),
                            $validated['sac_name'] => $sellingable->getAttribute($validated['sac_name']) + $selling->getAttribute('sac_count')
                        ]);
                    }

                    $sellingableData = [
                        'total_weight' => $sellingable->getAttribute('total_weight') - $validated['weight'],
                        $validated['sac_name'] => $sellingable->getAttribute($validated['sac_name']) - $validated['sac_count']
                    ];

                    $selling->sellingable()->update($sellingableData);
                    break;

                case 'potatoes':
                    $sac = $sellingable->sacs()->where('potato_id', $validated['type_id'])->where('name', $validated['sac_name'])->first();

                    if ($sac->getAttribute('sac_count') < $validated['sac_count']) {
                        $error = true;
                        break;
                    }

                    if($selling->getAttribute('sac_name') != $validated['sac_name']) {
                        $sac->update([
                            'sac_count' => $sac->sac_count + $selling->getAttribute('sac_count'),
                            'sac_weight' => $sac->sac_weight + $selling->getAttribute('weight'),
                        ]);
                    }

                    $sac->update([
                        'sac_count' => $sac->sac_count - $validated['sac_count'],
                        'sac_weight' => $sac->sac_weight - $validated['weight'],
                    ]);
                    break;
            }
        }

        if ($error) {
            return back()->with('message', 'Seçdiyiniz kisədə o qədər say mövcud deyil');
        }
    }
}
