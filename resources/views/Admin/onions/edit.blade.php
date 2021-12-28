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
                    <form action="{{$action}}" method="POST" enctype="multipart/form-data">
                        @csrf @method($method)

                        <div class="form-group">
                            <label for="post-title">Kimden</label>
                            <input type="text" value="{{ optional($data)->getAttribute('from_whom') }}" name="from_whom" class="form-control" id="post-title" placeholder="Kimden aldığınız daxil edin">
                            @error('from_whom')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Maşın Nömrəsi</label>
                            <input type="text" value="{{ optional($data)->getAttribute('car_number') }}" name="car_number" class="form-control" id="post-title" placeholder="Maşın nömrəsini daxil edin">
                            @error('car_number')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Sürücü Adı</label>
                            <input type="text" value="{{ optional($data)->getAttribute('driver_name') }}" name="driver_name" class="form-control" id="post-title" placeholder="Sürücü adını daxil edin">
                            @error('driver_name')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Tədarük Xərci</label>
                            <input type="number" value="{{ optional($data)->getAttribute('supply_cost') }}" name="supply_cost" class="form-control" id="post-title" placeholder="Tədarük xərcini daxil edin">
                            @error('supply_cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Maya Dəyəri</label>
                            <input type="number" value="{{ optional($data)->getAttribute('cost') }}" name="cost" class="form-control" id="post-title" placeholder="Maya dəyərini">
                            @error('cost')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Növü</label>
                            <input type="text" value="{{ optional($data)->getAttribute('type') }}" name="type" class="form-control" id="post-title" placeholder="Növünü daxil edin">
                            @error('type')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Çəkisi</label>
                            <input type="number" value="{{ optional($data)->getAttribute('total_weight') }}" name="total_weight" class="form-control" id="post-title" placeholder="Çəkisini daxil edin">
                            @error('total_weight')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Qırmızı Kisə Sayı</label>
                            <input type="number" value="{{ optional($data)->getAttribute('red_bag_number') }}" name="red_bag_number" class="form-control" id="post-title" placeholder="Qırmızı kisə sayını daxil edin">
                            @error('red_bag_number')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Sarı  Kisə Sayı</label>
                            <input type="number" value="{{ optional($data)->getAttribute('yellow_bag_number') }}" name="yellow_bag_number" class="form-control" id="post-title" placeholder="Sarı kisə sayını daxil edin">
                            @error('yellow_bag_number')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Lom  Kisə Sayı</label>
                            <input type="text" value="{{ optional($data)->getAttribute('lom_bag_number') }}" name="lom_bag_number" class="form-control" id="post-title" placeholder="Lom kisə sayını daxil edin">
                            @error('lom_bag_number')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Qiyməti</label>
                            <input type="number" value="{{ optional($data)->getAttribute('onion_price') }}" name="onion_price" class="form-control" id="post-title" placeholder="Qiymətini daxil edin">
                            @error('onion_price')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        @if ($method != "POST")
                            <div class="form-group form-check">
                                <input type="checkbox"  {{ optional($data)->getAttribute('onion_trash') == true ? 'checked' : '' }}  name="onion_trash" class="form-check-input" id="post-state">
                                <label class="form-check-label" for="post-state">Atxot Mal</label>
                            </div>
                        @endif
                        @if ($action)
                            <button type="submit" class="btn btn-primary">Əlavə Et</button>
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
