<?php

namespace App\Http\Livewire;

use App\Models\Potato;
use Livewire\Component;

class ShowSacs extends Component
{
    public array  $sacs;
    public ?string $action;
    public ?Potato $potato;

    public function mount()
    {
        $this->sacs = $this->potato ? $this->potato->sacs()->get(['id', 'name', 'sac_count', 'old_sac_count', 'sac_weight', 'total_weight'])->toArray() : [];
    }

    public function addSac()
    {
        $newArr = ['id' => null, 'name' => null, 'sac_count' => null, 'old_sac_count' => null, 'sac_weight' => null, 'total_weight' => null];
        $this->sacs[] = $newArr;
    }

    public function removeSac($index)
    {
        unset($this->sacs[$index]);
    }

    public function render()
    {
        return view('livewire.show-sacs');
    }
}
