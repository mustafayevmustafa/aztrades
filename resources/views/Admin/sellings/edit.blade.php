@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Satış Edin</h4>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-outline-primary" href="{{route('sellings.index')}}"><i class="mdi mdi-arrow-left"></i></a>
                        @if (is_null($action))
                            <a class="btn btn-outline-primary" href="{{route('sellings.edit', $data)}}">Edit</a>
                        @endif
                    </div>
                    <h4>Məhsul Çəkisi:{{$type->total_weight}}KQ</h4>
                    @if($type->getTable()=="onions")
                        <h4>Sarı Kisə Sayı:{{$type->yellow_bag_number}}</h4>
                        <h4>Qırmızı Kisə Sayı:{{$type->red_bag_number}}</h4>
                        <h4>Lom Kisə Sayı:{{$type->lom_bag_number}}</h4>
                    @else
                        <h4>Kisə Sayı:
                            @foreach($type->sacs as $sac)
                               {{$sac->sac_count}}
                            @endforeach
                        </h4>
                        <h4>Kisə Adı:
                            @foreach($type->sacs as $sac)
                                {{$sac->name}}
                            @endforeach
                        </h4>
                        <h4>Kisə Çəkisi:
                            @foreach($type->sacs as $sac)
                                {{$sac->sac_weight}}
                            @endforeach
                        </h4>
                    @endif
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf @method($method)
                        @if ($action)
                        @endif
                        <div class="form-group">
                            <label for="post-title">Kimə Satılır</label>
                            <input type="text" value="{{ optional($data)->getAttribute('customer') }}" name="customer" class="form-control" id="post-title" placeholder="Kimə Satılır">
                            @error('customer')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" value="{{ optional($data)->getAttribute('type') ?? request()->get('type')=="onion" ? "sogan" : "kartof" }}" name="type" class="form-control" id="post-title" placeholder="Enter title" readonly>
                            @error('type')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="text" value="{{$type->car_number}}" class="form-control" placeholder="Enter title" readonly>
                            <input type="hidden" value="{{$type->id}}" name="type_id">
                            @error('type_id')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Kisə Sayı</label>
                            <input type="text" value="{{ optional($data)->getAttribute('sac_count') }}" name="sac_count" class="form-control" id="post-title" placeholder="Kisə Sayı">
                            @error('sac_count')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Çəki(kq)</label>
                            <input type="text" value="{{ optional($data)->getAttribute('weight') }}" name="weight" class="form-control" id="post-title" placeholder="Çəki(kq)">
                            @error('weight')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Qiymət</label>
                            <input type="text" value="{{ optional($data)->getAttribute('price') }}" name="price" class="form-control" id="post-title" placeholder="Qiymət">
                            @error('price')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Qeyd</label>
                            <input type="text" value="{{ optional($data)->getAttribute('content') }}" name="content" class="form-control" id="post-title" placeholder="Qeyd">
                            @error('content')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group form-check">
                                <input type="checkbox"   name="status" class="form-check-input" id="post-state">
                            <label class="form-check-label" for="post-state">Borc</label>
                        </div>

                        @if ($action)
                            <button type="submit" class="btn btn-primary">Sat</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
                @section('script')
    @if (is_null($action))
        <script>
            $('form :input').attr('disabled', true)
        </script>
    @endif
@endsection
@endsection
