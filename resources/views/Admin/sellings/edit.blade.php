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
                    </div>

                    <div class="my-3">
                        <h4><strong>Məhsul Çəkisi:</strong> {{$type->total_weight}} kg</h4>
                        @if($type->getTable() == "onions")
                            <h4><strong>Sarı Kisə Sayı:</strong> {{$type->yellow_bag_number}}</h4>
                            <h4><strong>Qırmızı Kisə Sayı:</strong> {{$type->red_bag_number}}</h4>
                            <h4><strong>Lom Kisə Sayı:</strong> {{$type->lom_bag_number}}</h4>
                        @else
                            @foreach($type->sacs as $sac)
                                <h4><strong>{{$sac->name}}:</strong> Sayı: {{$sac->sac_count}}, Kisə həcmi: {{$sac->sac_weight}} kg, Ümumi həcm: {{$sac->total_weight}} kg</h4>
                            @endforeach
                        @endif

                    </div>

                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf @method($method)

                        @if (session('message'))
                            <div class="alert alert-danger my-2">
                                {{ session('message') }}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="post-title">Növü</label>
                            @php($typeName = $data->getAttribute('type') ? ($data->getAttribute('type') == "onion" ? "Sogan" : "Kartof") : (request()->get('type') == "onion" ? "Sogan" : "Kartof"))
                            <input type="text"   value="{{ $typeName }}" class="form-control" readonly>
                            <input type="hidden" value="{{ $data->getAttribute('type') ?? request()->get('type') }}" name="type"  class="form-control" readonly>
                            @error('type')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <input type="text" value="{{$type->getAttribute('info')}}" class="form-control" readonly>
                            <input type="hidden" value="{{$type->id}}" name="type_id">
                            @error('type_id')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Kimə Satılır</label>
                            <input type="text" value="{{ $data->getAttribute('customer') }}" name="customer" class="form-control" id="post-title" placeholder="Kimə Satılır">
                            @error('customer')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Kisə Adı</label>
                            <select name="sac_name" class="form-control">
                                <option value="">Kisə seç</option>
                                @foreach($sacs as $index => $sac)
                                    <option value="{{$index}}" @if($data->getAttribute('sac_name') == $index) selected @endif>{{$sac}}</option>
                                @endforeach
                            </select>
                            @if($method == 'PUT')
                                <input type="hidden" value="{{$data->getAttribute('sac_name')}}" name="sac_name">
                            @endif
                            @error('sac_name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Kisə Sayı</label>
                            <input type="number" min="1" step="1" value="{{ $data->getAttribute('sac_count') }}" name="sac_count" class="form-control" id="post-title" placeholder="Kisə Sayı">
                            @error('sac_count')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        @if(
                            ($type->getTable() == 'onions' && $type->getAttribute('total_weight') != 0) ||
                            ($type->getTable() == 'potatoes')
                        )
                            <div class="form-group">
                                <label for="post-title">Çəki (kq)</label>
                                <input type="number" min="0.01" step=".01" value="{{ $data->getAttribute('weight') }}" name="weight" class="form-control" id="post-title" placeholder="Çəki (kq)">
                                @error('weight')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="post-title" class="text-danger">Qiymət (AZN)</label>
                            <input type="number" min="0.01" step=".01" value="{{ $data->getAttribute('price') }}" name="price" class="form-control" id="post-title" placeholder="Qiymət">
                            @error('price')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Qeyd</label>
                            <input type="text" value="{{ $data->getAttribute('content') }}" name="content" class="form-control" id="post-title" placeholder="Qeyd">
                            @error('content')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        @if(($data->getAttribute('was_debt')) || $method == 'POST')
                            <div class="pl-0 form-group col-12">
                                <div class="form-check">
                                    <input type="checkbox"  name="was_debt" class="form-check-input" id="data-status" @if($data->getAttribute('was_debt')) checked @endif @if($method != 'POST') readonly @endif>
                                    <label class="form-check-label" for="data-status">Borc</label>
                                </div>
                            </div>
                        @endif

                        @if($action)
                            <button type="submit" class="btn btn-primary">@if($method == 'POST') Sat @else Yadda saxla @endif</button>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @if ($method != 'POST')
        <script>
            $('form :input').attr('disabled', true);
        </script>
    @endif
@endsection

