<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Menu extends Component
{

    public array $items = [];

    public function __construct()
    {
        $this->items = [
            (object) [
                'name' => 'Məlumat Səhifəsi',
                'url' => route('dashboard.index'),
                'icon' => 'mdi-airplay',
                'permission' => 'generally',
                'has_arrow' => false
            ],
            (object) [
                'name' => 'Qeydlər',
                'url' => route('notes.index'),
                'icon' => 'mdi-comment-text',
                'permission' => 'generally',
                'has_arrow' => false
            ],

            (object) [
                'name' => 'Soğan',
                'url' => route('onions.index'),
                'icon' => 'mdi-google-chrome',
                'permission' => 'admin',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'Kartof',
                'url' => route('potatoes.index'),
                'icon' => 'mdi-football-australian',
                'permission' => 'admin',
                'has_arrow' => false
            ],

            (object) [
                'name' => 'Satışlar',
                'url' => route('sellings.index'),
                'icon' => 'mdi-cash-multiple',
                'permission' => 'generally',
                'has_arrow' => false,
            ],
            (object) [
                'name' => 'Bağlanan Satışlar',
                'url' => route('сlosed_sellings.index'),
                'icon' => 'mdi-cash',
                'permission' => 'generally',
                'has_arrow' => false,
            ],
            (object) [
                'name' => 'Borclar',
                'url' => 'javascript:void(0)',
                'icon' => 'mdi-cash-usd',
                'permission' => 'generally',
                'has_arrow' => true,
                'inner' => [
                    (object) [
                        'name' => 'Borca geden',
                        'url' => route('debts.expense'),
                        'icon' => 'mdi-cash',
                        'permission' => 'generally',
                    ],
                    (object) [
                        'name' => 'Borcdan gelen',
                        'url' => route('debts.income'),
                        'icon' => 'mdi-cash',
                        'permission' => 'generally',
                    ],
                ]
            ],

            (object) [
                'name' => 'Atxodlar',
                'url' => route('waste.index'),
                'icon' => 'mdi-delete-variant',
                'permission' => 'generally',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'Rollar',
                'url' => route('roles.index'),
                'icon' => 'mdi-account-key',
                'permission' => 'admin',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'İstifadəcilər',
                'url' => route('users.index'),
                'icon' => 'mdi-account-multiple-plus',
                'permission' => 'admin',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'Xərclər',
                'url' => route('expenses.index'),
                'icon' => 'mdi-cash-multiple',
                'permission' => 'generally',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'Xərclərin Növü',
                'url' => route('expenses_types.index'),
                'icon' => 'mdi-cash',
                'permission' => 'admin',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'Ölkə',
                'url' => route('countries.index'),
                'icon' => 'mdi mdi-earth',
                'permission' => 'admin',
                'has_arrow' => false,
            ],

            (object) [
                'name' => 'Şəhər',
                'url' => route('cities.index'),
                'icon' => 'mdi-map-marker',
                'permission' => 'admin',
                'has_arrow' => false,
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
                            <a href="{{$item->url}}" @class(['waves-effect', 'mm-active' => $active, 'has-arrow' => $item->has_arrow])>
                                <i class="mdi {{$item->icon}}"></i>
                                <span>{{$item->name}}</span>
                            </a>
                            @if($item->has_arrow)
                                <ul class="sub-menu mm-collapse">
                                    @foreach($item->inner as $inner)
                                        <li><a href="{{$inner->url}}">{{$inner->name}}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endcan
                @endforeach
            </ul>
        blade;
    }
}
