<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{

    public array $items = [];

    public function __construct()
    {
        $this->items = (array) [
            (object) [
                'name' => 'Məlumat Səhifəsi',
                'url' => route('dashboard.index'),
                'icon' => 'mdi-airplay',
            ],

            (object) [
                'name' => 'Soğan',
                'url' => route('onions.index'),
                'icon' => 'mdi-google-chrome',
            ],

            (object) [
                'name' => 'Kartof',
                'url' => route('potatoes.index'),
                'icon' => 'mdi-football-australian',
            ],

            (object) [
                'name' => 'Satışlar',
                'url' => route('sellings.index'),
                'icon' => 'mdi-cash-multiple',
            ],

            (object) [
                'name' => 'Borclar',
                'url' => route('debts.index'),
                'icon' => 'mdi-cash-usd',
            ],

            (object) [
                'name' => 'Atxodlar',
                'url' => route('waste.index'),
                'icon' => 'mdi-delete-variant',
            ],

            (object) [
                'name' => 'Icazələr',
                'url' => route('roles.index'),
                'icon' => 'mdi-account-key',
            ],

            (object) [
                'name' => 'İstifadəcilər',
                'url' => route('admins.index'),
                'icon' => 'mdi-account-multiple-plus',
            ],

            (object) [
                'name' => 'Xərclər',
                'url' => route('expenses.index'),
                'icon' => 'mdi-cash-multiple',
            ],

            (object) [
                'name' => 'Xərclərin Növü',
                'url' => route('expenses_types.index'),
                'icon' => 'mdi-cash',
            ],

            (object) [
                'name' => 'Ölkə',
                'url' => route('countries.index'),
                'icon' => 'mdi mdi-earth',
            ],

            (object) [
                'name' => 'Şəhər',
                'url' => route('cities.index'),
                'icon' => 'mdi-map-marker',
            ],
        ];
    }

    public function render(): string
    {
        return /* @lang Blade */
            <<<'blade'
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Menu</li>
                @foreach ($items as $item)
                    @php($active = request()->url() == $item->url || request()->segment(2) == strtolower($item->name))
                     <li @class(['active' => $active])>
                        <a href="{{$item->url}}" @class(['waves-effect', 'mm-active' => $active])>
                            <i class="mdi {{$item->icon}}"></i>
                            <span>{{$item->name}}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        blade;
    }
}
