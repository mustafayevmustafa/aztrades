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
        @foreach($onions as $car_number => $sells)
            <div class="col-12 col-md-6 card pt-2" style="height:300px;">
                <h5 style="color:blue">{{$car_number}}</h5>
                <div class="overflow-auto">
                    @foreach($sells as $selling)
                        <ul style="list-style:none;padding:0!important;margin: 0!important;">
                            <li @if($selling->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                @if($selling->weight) {{$selling->weight}} kq
                                @elseif($selling->sac_name) {{$selling->sac_count}}
                                {{\App\Models\Onion::bags()[$selling->sac_name]}}
                                @endif - {{$selling->price}} AZN ({{$selling->created_at}})
                            </li>
                        </ul>
                        <hr class="m-1">
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection