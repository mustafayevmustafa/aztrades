@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Potatoes</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-outline-primary" href="{{route('potatoes.index')}}"><i class="mdi mdi-arrow-left"></i></a>
                        @if (is_null($action))
                            <a class="btn btn-outline-primary" href="{{route('potatoes.edit', $data)}}">Edit</a>
                        @endif
                    </div>
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf @method($method)
                      <div class="row">
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Ölkə</label>
                                  <select name="country_id" id="" class="form-control">
                                      <option value="">Ölkə Seçin</option>
                                      @foreach($countries as $country)
                                          <option value="{{$country->id}}">{{$country->name}}</option>
                                      @endforeach
                                  </select>
                                  @error('from_whom')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Kimden</label>
                                  <input type="text" value="{{ optional($data)->getAttribute('from_whom') }}" name="from_whom" class="form-control" id="post-title" placeholder="Kimdən aldığınızı daxil edin">
                                  @error('from_whom')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Partiyası</label>
                                  <input type="text" value="{{ optional($data)->getAttribute('party') }}" name="party" class="form-control" id="post-title" placeholder="Partiyanı daxil edin">
                                  @error('party')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Maşın Nömrəsi</label>
                                  <input type="text" value="{{ optional($data)->getAttribute('car_number') }}" name="car_number" class="form-control" id="post-title" placeholder="Maşın nömrəsini daxil edin">
                                  @error('car_number')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Sürücü Adı</label>
                                  <input type="text" value="{{ optional($data)->getAttribute('driver_name') }}" name="driver_name" class="form-control" id="post-title" placeholder="Sürücü adını daxil edin">
                                  @error('driver_name')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Sürücü Xərci</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('driver_cost') }}" name="driver_cost" class="form-control" id="post-title" placeholder="Sürücü xərcini daxil edin">
                                  @error('driver_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Maya Dəyəri</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('cost') }}" name="cost" class="form-control" id="post-title" placeholder="Maya dəyərini daxil edin">
                                  @error('cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Gömrük Xərci</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('custom_cost') }}" name="custom_cost" class="form-control" id="post-title" placeholder="Gömrük xərcini daxil edin">
                                  @error('custom_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Bazar Xərci</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('market_cost') }}" name="market_cost" class="form-control" id="post-title" placeholder="Bazar xərcini daxil edin">
                                  @error('market_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Ümumi Çəkisi</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('total_weight') }}" name="total_weight" class="form-control" id="post-title" placeholder="Ümumi çəkisini daxil edin">
                                  @error('total_weight')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Digər Xərc</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('other_cost') }}" name="other_cost" class="form-control" id="post-title" placeholder="Digər xərcini daxil edin"></br></br>
                                  @error('other_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label for="post-title">Qiyməti</label>
                                  <input type="number" value="{{ optional($data)->getAttribute('potato_price') }}" name="potato_price" class="form-control" id="post-title" placeholder="Qiymətini daxil edin"></br></br>
                                  @error('potato_price')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>
                          <div class="col-12 ">
                              <div class="my-3">
                                  <h4>Potato sacs</h4>
                                  @livewire('show-sacs', ['potato' => $data, 'action' => $action])
                              </div>

                              @if ($action)
                                  <button type="submit" class="btn btn-primary">Əlavə Et</button>
                              @endif
                          </div>
                      </div>

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



