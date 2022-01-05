@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Soğanlar</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 p-0">
            <div class="card">
                <div class="card-body p-1">
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-outline-primary" href="{{route('onions.index')}}"><i class="mdi mdi-arrow-left"></i></a>
                        <div>
                            @if($action != 'POST')
                                <button type="button" class="btn btn-outline-danger mr-2" data-toggle="modal" data-target="#wasteModal">
                                    Atxod elave et
                                </button>
                            @endif

                            @if (is_null($action))
                                <a class="btn btn-outline-primary" href="{{route('onions.edit', $data)}}">Edit</a>
                            @endif
                        </div>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger mt-2">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if($method != 'POST')
                        <div class="modal fade" id="wasteModal">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Atxod elave et</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="{{route('onions.update', $data)}}" method="POST">
                                        @csrf @method('PUT')
                                        <input type="hidden" value="1" name="is_waste">
                                        <div class="modal-body">
                                            <div class="form-group col-12">
                                                <label for="">Kisə</label>
                                                <select name="waste_sac_name" class="form-control">
                                                    <option value="">Kisə Seçin</option>
                                                    @foreach($bags as $key => $bag)
                                                        <option value="{{$key}}">{{$bag}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group col-12">
                                                <label for="">Kisə sayi</label>
                                                <input type="number" min="1" max="{{$data->getAttribute('least_bag_count')}}" step="1" class="form-control" name="waste_sac_count">
                                            </div>

                                            <div class="form-group col-12">
                                                <label for="">Ceki (kg)</label>
                                                <input type="number" min="1" max="{{$data->getAttribute('total_weight')}}" step="1" class="form-control" name="waste_weight">
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bagla</button>
                                            <button type="submit" class="btn btn-primary">Yadda saxla</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{$action}}" method="POST" class="row m-0" id="manageForm">
                        @csrf @method($method)

                        <div class="form-group col-12 col-md-6">
                            <label for="">Şəhər</label>
                            <select name="city_id" class="form-control">
                                <option value="">Şəhər Seçin</option>
                                @foreach($cities as $city)
                                    <option value="{{$city->id}}" @if($data->city_id == $city->id) selected @endif>{{$city->name}}</option>
                                @endforeach
                            </select>
                            @error('city_id')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Kimden</label>
                            <input type="text" value="{{ $data->getAttribute('from_whom') }}" name="from_whom" class="form-control" placeholder="Kimden aldığınız daxil edin">
                            @error('from_whom')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Maşın Nömrəsi</label>
                            <input type="text" value="{{ $data->getAttribute('car_number') }}" name="car_number" class="form-control" placeholder="Maşın nömrəsini daxil edin">
                            @error('car_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Sürücü Adı</label>
                            <input type="text" value="{{ $data->getAttribute('driver_name') }}" name="driver_name" class="form-control" placeholder="Sürücü adını daxil edin">
                            @error('driver_name')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Sürücü Xərci (AZN)</label>
                            <input type="number" min="0.1" step=".1" value="{{ $data->getAttribute('driver_cost') }}" name="driver_cost" class="form-control" placeholder="Sürücü xərcini daxil edin">
                            @error('supply_cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Tədarük Xərci (AZN)</label>
                            <input type="number" min="0.1" step=".1" value="{{ $data->getAttribute('supply_cost') }}" name="supply_cost" class="form-control" placeholder="Tədarük xərcini daxil edin">
                            @error('supply_cost')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Maya Dəyəri (AZN)</label>
                            <input type="number" min="0.1" step=".1" value="{{ $data->getAttribute('cost') }}" name="cost" class="form-control" placeholder="Maya dəyərini">
                            @error('cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Çəkisi (kg)</label>
                            <input type="number" min="0.1" step=".1" value="{{ $data->getAttribute('total_weight') }}" name="total_weight" class="form-control" placeholder="Çəkisini daxil edin">
                            @error('total_weight')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Qırmızı Kisə Sayı</label>
                            <input type="number" min="1" step="1" value="{{ $data->getAttribute('red_bag_number') }}" name="red_bag_number" class="form-control" placeholder="Qırmızı kisə sayını daxil edin">
                            <small class="text-primary">Daxil olan: {{$old_values[0] ?? 0}}</small>
                            @error('red_bag_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Sarı Kisə Sayı</label>
                            <input type="number" min="1" step="1" value="{{ $data->getAttribute('yellow_bag_number') }}" name="yellow_bag_number" class="form-control" placeholder="Sarı kisə sayını daxil edin">
                            <small class="text-primary">Daxil olan: {{$old_values[1] ?? 0}}</small>
                            @error('yellow_bag_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group col-12 col-md-6">
                            <label for="post-title">Lom Kisə Sayı</label>
                            <input type="number" min="1" step="1" value="{{ $data->getAttribute('lom_bag_number') }}" name="lom_bag_number" class="form-control" placeholder="Lom kisə sayını daxil edin">
                            <small class="text-primary">Daxil olan: {{$old_values[2] ?? 0}}</small>
                            @error('lom_bag_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        @if ($method != "POST")
                            <div class="form-group col-12 form-check">
                                <input id="data-status" type="checkbox" {{ $data->getAttribute('status') == true ? 'checked' : '' }}  name="status" class="form-check-input">
                                <label class="form-check-label" for="data-status">Aktiv</label>
                            </div>
                        @endif

                        @if ($action)
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Yadda saxla</button>
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    @if (is_null($action))
        <script>
            $('#manageForm :input').attr('disabled', true)
        </script>
    @endif
@endsection
