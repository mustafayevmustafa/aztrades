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
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-outline-primary" href="{{route('onions.index')}}"><i class="mdi mdi-arrow-left"></i></a>
                        @if (is_null($action))
                            <a class="btn btn-outline-primary" href="{{route('onions.edit', $data)}}">Edit</a>
                        @endif
                    </div>

                    <form action="{{$action}}" method="POST">
                        @csrf @method($method)

                        <div class="form-group">
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

                        <div class="form-group">
                            <label for="post-title">Kimden</label>
                            <input type="text" value="{{ $data->getAttribute('from_whom') }}" name="from_whom" class="form-control" placeholder="Kimden aldığınız daxil edin">
                            @error('from_whom')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Maşın Nömrəsi</label>
                            <input type="text" value="{{ $data->getAttribute('car_number') }}" name="car_number" class="form-control" placeholder="Maşın nömrəsini daxil edin">
                            @error('car_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Sürücü Adı</label>
                            <input type="text" value="{{ $data->getAttribute('driver_name') }}" name="driver_name" class="form-control" placeholder="Sürücü adını daxil edin">
                            @error('driver_name')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Sürücü Xərci (AZN)</label>
                            <input type="number" min="0" step=".1" value="{{ $data->getAttribute('driver_cost') }}" name="driver_cost" class="form-control" placeholder="Sürücü xərcini daxil edin">
                            @error('supply_cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Tədarük Xərci (AZN)</label>
                            <input type="number" min="0" step=".1" value="{{ $data->getAttribute('supply_cost') }}" name="supply_cost" class="form-control" placeholder="Tədarük xərcini daxil edin">
                            @error('supply_cost')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Maya Dəyəri (AZN)</label>
                            <input type="number" min="0" step=".1" value="{{ $data->getAttribute('cost') }}" name="cost" class="form-control" placeholder="Maya dəyərini">
                            @error('cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Çəkisi (kg)</label>
                            <input type="number" min="0" step=".1" value="{{ $data->getAttribute('total_weight') }}" name="total_weight" class="form-control" placeholder="Çəkisini daxil edin">
                            @error('total_weight')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Qırmızı Kisə Sayı</label>
                            <input type="number" min="0" step="1" value="{{ $data->getAttribute('red_bag_number') }}" name="red_bag_number" class="form-control" placeholder="Qırmızı kisə sayını daxil edin">
                            @error('red_bag_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Sarı Kisə Sayı</label>
                            <input type="number" min="0" step="1" value="{{ $data->getAttribute('yellow_bag_number') }}" name="yellow_bag_number" class="form-control" placeholder="Sarı kisə sayını daxil edin">
                            @error('yellow_bag_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="post-title">Lom Kisə Sayı</label>
                            <input type="number" min="0" step="1" value="{{ $data->getAttribute('lom_bag_number') }}" name="lom_bag_number" class="form-control" placeholder="Lom kisə sayını daxil edin">
                            @error('lom_bag_number')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        @if ($method != "POST")
                            <div class="form-group form-check">
                                <input id="data-status" type="checkbox" {{ $data->getAttribute('is_trash') == true ? 'checked' : '' }}  name="is_trash" class="form-check-input">
                                <label class="form-check-label" for="data-status">Atxot Mal</label>
                            </div>
                        @endif

                        @if ($action)
                            <button type="submit" class="btn btn-primary">Yadda saxla</button>
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
            $('form :input').attr('disabled', true)
        </script>
    @endif
@endsection
