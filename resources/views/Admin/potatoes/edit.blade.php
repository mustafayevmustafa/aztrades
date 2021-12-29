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
                <div class="card-body p-0">
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
                                  <label>Ölkə</label>
                                  <select name="country_id" class="form-control">
                                      <option value="">Ölkə Seçin</option>
                                      @foreach($countries as $country)
                                          <option value="{{$country->id}}" @if($data->getAttribute('country_id') == $country->id) selected @endif>
                                              {{$country->name}}
                                          </option>
                                      @endforeach
                                  </select>
                                  @error('country_id')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label>Kimden</label>
                                  <input type="text" value="{{ $data->getAttribute('from_whom') }}" name="from_whom" class="form-control" placeholder="Kimdən aldığınızı daxil edin">
                                  @error('from_whom')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label>Partiyası</label>
                                  <input type="text" value="{{ $data->getAttribute('party') }}" name="party" class="form-control"  placeholder="Partiyanı daxil edin">
                                  @error('party')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Maşın Nömrəsi</label>
                                  <input type="text" value="{{ $data->getAttribute('car_number') }}" name="car_number" class="form-control"  placeholder="Maşın nömrəsini daxil edin">
                                  @error('car_number')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Sürücü Adı</label>
                                  <input type="text" value="{{ $data->getAttribute('driver_name') }}" name="driver_name" class="form-control"  placeholder="Sürücü adını daxil edin">
                                  @error('driver_name')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Sürücü Xərci</label>
                                  <input type="number" min="0" step=".1" value="{{ $data->getAttribute('driver_cost') }}" name="driver_cost" class="form-control"  placeholder="Sürücü xərcini daxil edin">
                                  @error('driver_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Gömrük Xərci</label>
                                  <input type="number" min="0" step=".1" value="{{ $data->getAttribute('custom_cost') }}" name="custom_cost" class="form-control"  placeholder="Gömrük xərcini daxil edin">
                                  @error('custom_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Maya Dəyəri</label>
                                  <input type="number" min="0" step=".1" value="{{ $data->getAttribute('cost') }}" name="cost" class="form-control"  placeholder="Maya dəyərini daxil edin">
                                  @error('cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Bazar Xərci</label>
                                  <input type="number" min="0" step=".1" value="{{ $data->getAttribute('market_cost') }}" name="market_cost" class="form-control"  placeholder="Bazar xərcini daxil edin">
                                  @error('market_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Digər Xərc</label>
                                  <input type="number" min="0" step=".1" value="{{ $data->getAttribute('other_cost') }}" name="other_cost" class="form-control"  placeholder="Digər xərcini daxil edin"></br></br>
                                  @error('other_cost')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 col-md-4">
                              <div class="form-group">
                                  <label >Ümumi Çəkisi</label>
                                  <input type="number" value="{{ $data->getAttribute('total_weight') }}" name="total_weight" class="form-control"  placeholder="Ümumi çəkisini daxil edin">
                                  @error('total_weight')
                                  <p class="text-danger">
                                      {{ $message }}
                                  </p>
                                  @enderror
                              </div>
                          </div>

                          <div class="col-12 ">
                              <div class="my-3">
                                  <h4>Kartof kisələri</h4>
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



