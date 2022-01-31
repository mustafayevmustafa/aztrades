@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Statistika</h4>
            </div>
        </div>
    </div>

    <div class="row">
        @foreach($potatoes as $id => $sells)
            <div class="col-12 col-md-6  card pt-2 " style="height:450px;">
                <h5 style="color:blue">{{\App\Models\Potato::find($id)->getAttribute('info')}}</h5>
                <div class="overflow-auto">
                    @php
                        $data = [
                            'current' => [
                            ],
                            'total' => [

                            ]
                        ];
                    @endphp
                    @foreach($sells as $selling)
                        @php
                            if(is_null($selling->closed_rate_id)){
                                @$data['current']["price"] += $selling->price;
                                if ($selling->sac_name) {
                                     @$data['current'][$selling->sac_name] += $selling->sac_count;
                                }
                                if($selling->weight){
                                    @$data['current']["weight"] += $selling->weight;
                                }elseif($selling->sac_count){
                                    @$data['current']["weight"] += $selling->sac_count * \App\Models\PotatoSac::find($selling->sac_name)->sac_weight;
                                }
                            }

                            if ($selling->sac_name) {
                                 @$data['total'][$selling->sac_name] += $selling->sac_count;
                            }
                            if($selling->weight){
                                @$data['total']["weight"] += $selling->weight;
                            }elseif($selling->sac_count){
                                @$data['total']["weight"] += $selling->sac_count * \App\Models\PotatoSac::find($selling->sac_name)->sac_weight;
                            }
                        @endphp
                        <ul style="list-style:none;padding:0!important;margin: 0!important;">
                            <li @if($selling->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                <strong>
                                @if($selling->weight)
                                    {{$selling->weight}} kq
                                @elseif($selling->sac_name) {{$selling->sac_count}} {{\App\Models\PotatoSac::find($selling->sac_name)->getAttribute('name')}}
                                @endif - {{$selling->price}} AZN </strong><span style="color:red;"> ({{$selling->customer}}) </span>({{$selling->created_at}})
                            </li>
                        </ul>
                        <hr class="m-1">
                    @endforeach
                </div>

                @foreach($data as $key => $sacs)
                    @if($key == "current")
                        @foreach($sacs as $k => $sac)
                            @if($k=="weight")
                                <p><strong style="color:darkmagenta;">Halhazırdakı Ceki : <span style="color:brown">{{$sac}} kq </span></strong></p>
                            @elseif($k=="price")
                                <p><strong style="color:darkmagenta;">Halhazırdakı Dovriyye:</strong> <span style="color:orange">{{$sac}} AZN </span></p>
                            @else
                                <p><strong>Halhazırdakı {{\App\Models\PotatoSac::find($k)->name}}: {{$sac}} Kisə</strong></p>
                            @endif
                        @endforeach
                        -------------------------------
                    @elseif($key == "total")
                        @foreach($sacs as $k => $sac)
                                @if($k=="weight")
                                    <p><strong>Toplam Ceki : {{$sac}} kq</strong></p>
                                @else
                                    <p><strong>{{\App\Models\PotatoSac::find($k)->name}}: {{$sac}} Kisə</strong></p>
                                @endif
                        @endforeach
                    @endif
                @endforeach
                <p><strong>Dovriyye:</strong> {{$sells->sum('price')}} AZN</p>
            </div>
        @endforeach
    </div>
@endsection

