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
                'permission' => 'generally'
            ],

            (object) [
                'name' => 'Soğan',
                'url' => route('onions.index'),
                'icon' => 'mdi-google-chrome',
                'permission' => 'admin'
            ],

            (object) [
                'name' => 'Kartof',
                'url' => route('potatoes.index'),
                'icon' => 'mdi-football-australian',
                'permission' => 'admin'
            ],

            (object) [
                'name' => 'Satışlar',
                'url' => route('sellings.index'),
                'icon' => 'mdi-cash-multiple',
                'permission' => 'generally'
            ],

            (object) [
                'name' => 'Borclar',
                'url' => route('debts.index'),
                'icon' => 'mdi-cash-usd',
                'permission' => 'generally'
            ],

            (object) [
                'name' => 'Atxodlar',
                'url' => route('waste.index'),
                'icon' => 'mdi-delete-variant',
                'permission' => 'generally'
            ],

            (object) [
                'name' => 'Icazələr',
                'url' => route('roles.index'),
                'icon' => 'mdi-account-key',
                'permission' => 'admin'
            ],

            (object) [
                'name' => 'İstifadəcilər',
                'url' => route('admins.index'),
                'icon' => 'mdi-account-multiple-plus',
                'permission' => 'admin'
            ],

            (object) [
                'name' => 'Xərclər',
                'url' => route('expenses.index'),
                'icon' => 'mdi-cash-multiple',
                'permission' => 'generally',
            ],

            (object) [
                'name' => 'Xərclərin Növü',
                'url' => route('expenses_types.index'),
                'icon' => 'mdi-cash',
                'permission' => 'admin'
            ],

            (object) [
                'name' => 'Ölkə',
                'url' => route('countries.index'),
                'icon' => 'mdi mdi-earth',
                'permission' => 'admin'
            ],

            (object) [
                'name' => 'Şəhər',
                'url' => route('cities.index'),
                'icon' => 'mdi-map-marker',
                'permission' => 'admin'
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
                    @can($item->permission)
                        @php($active = request()->url() == $item->url || request()->segment(2) == strtolower($item->name))
                         <li @class(['active' => $active])>
                            <a href="{{$item->url}}" @class(['waves-effect', 'mm-active' => $active])>
                                <i class="mdi {{$item->icon}}"></i>
                                <span>{{$item->name}}</span>
                            </a>
                        </li>
                    @endcan
                @endforeach
            </ul>
        blade;
    }
}
