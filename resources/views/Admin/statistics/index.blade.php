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
        @foreach($closed as $type => $sells)
            <div class="col-12">
                <h5>{{$type == \App\Models\Onion::class ? 'Soğanlar' : 'Kartoflar'}}</h5>
                <div class="row m-0">
                    @foreach($sells->groupBy(['sellingable_id']) as $id => $sell)
                        <div class="col-12 col-md-6  card pt-2 " style="height:450px;">
                            <h5 style="color:blue">{{$type == \App\Models\Onion::class ? \App\Models\Onion::find($id)->info : \App\Models\Potato::find($id)->info}}</h5>
                            <div class="overflow-auto">
                                @php
                                    $data = [];
                                @endphp
                                @foreach($sell as $selling)
                                    @php
                                          if($selling->sac_name){
                                                @$data[$selling->sac_name] += $selling->sac_count;
                                          }
                                          if($selling->weight){
                                                 @$data["weight"] += $selling->weight;
                                          }
                                          elseif($selling->sac_count){
                                                @$data["weight"] += $selling->sac_count * \App\Models\PotatoSac::find($selling->sac_name)->sac_weight;
                                          }

                                    @endphp
                                    @if($selling->type == "potato")
                                        <ul style="list-style:none;padding:0!important;margin: 0!important;">
                                            <li @if($selling->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                                <b>  @if($selling->weight)
                                                        {{$selling->weight}}kq
                                                    @elseif($selling->sac_name)
                                                        {{$selling->sac_count}} {{\App\Models\PotatoSac::find($selling->sac_name)->getAttribute('name')}}
                                                        Kisə @endif - {{$selling->price}} AZN  </b>
                                                        ({{$selling->customer}})({{$selling->customer}})({{$selling->created_at}})
                                            </li>
                                        </ul>
                                        <hr class="m-1">
                                    @elseif($selling->type == "onion")
                                        <ul style="list-style:none;padding:0!important;margin: 0!important;">
                                            <li @if($selling->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                                <strong> @if($selling->weight){{$selling->weight}} kq
                                                    @elseif($selling->sac_name) {{$selling->sac_count}}
                                                        {{\App\Models\Onion::bags()[$selling->sac_name]}}
                                                    @endif - {{$selling->price}} AZN  </strong><span style="color:red;">({{$selling->customer}})</span>({{$selling->created_at}})
                                            </li>
                                        </ul>
                                        <hr class="m-1">
                                    @endif
                                @endforeach
                            </div>
                            <div>
                                <p><strong>Dovriyye:</strong> {{$sell->sum('price')}} AZN</p>
                                <p><strong>Xercler:</strong> {{$expence->sum('expense')}} AZN</p>
                                <p><strong>Borca aldigim pul (AZN):</strong> {{$debet->sum('expense')}} AZN</p>
                                <p><strong>Borcdan gozlənilən pul (AZN) :</strong> {{$debet_income->sum('expense')}} AZN</p>
                                @foreach($data as $key => $sac)
                                    @if($key=="weight")
                                        <p><strong>Toplam Ceki : {{$sac}} kq</strong></p>
                                    @elseif(is_numeric($key))
                                        <p><strong>{{\App\Models\PotatoSac::find(1)->getAttribute('name')}}: {{$sac}} Kisə</strong></p>
                                    @else
                                        <p><strong>{{\App\Models\Onion::bags()[$key]}}: {{$sac}} </strong></p>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

