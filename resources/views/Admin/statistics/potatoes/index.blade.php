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
                        $data = [];
                    @endphp
                    @foreach($sells as $selling)
                        @php
                            if ($selling->sac_name) {
                                @$data[$selling->sac_name] += $selling->sac_count;
                            }
                        @endphp
                        <ul style="list-style:none;padding:0!important;margin: 0!important;">
                            <li @if($selling->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                <strong>  @if($selling->weight)
                                    {{$selling->weight}} kq
                                @elseif($selling->sac_name) {{$selling->sac_count}} {{\App\Models\PotatoSac::find($selling->sac_name)->getAttribute('name')}}
                                @endif - {{$selling->price}} AZN - {{ $selling->getAttribute('was_debt') ? "Borc" : "Nagd" }}</strong>({{$selling->customer}})({{$selling->created_at}})
                            </li>
                        </ul>
                        <hr class="m-1">
                    @endforeach

                </div>
                <div>
                    <p><strong>Toplam Pul:</strong> {{$sells->sum('price')}} AZN</p>
                    <p><strong>Toplam Ceki:</strong> {{$sells->sum('weight')}} kq</p>
                    @foreach($data as $key => $sac)
                        <p><strong>{{\App\Models\PotatoSac::find($key)->name}}: {{$sac}}</strong></p>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>
@endsection

