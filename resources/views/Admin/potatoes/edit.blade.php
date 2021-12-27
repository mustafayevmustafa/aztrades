@extends('Admin.layout.master')

@section('content')
    <main class="py-5">
        <div class="container">
            <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                @csrf @method($method)
                @if ($action)
                @endif
                <div class="form-group">
                    <label for="post-title">Kimden</label>
                    <input type="text" value="{{ optional($data)->getAttribute('from_whom') }}" name="from_whom" class="form-control" id="post-title" placeholder="Enter title">
                    @error('from_whom')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-title">Partiyası</label>
                    <input type="text" value="{{ optional($data)->getAttribute('from_whom') }}" name="from_whom" class="form-control" id="post-title" placeholder="Enter title">
                    @error('from_whom')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-title">Maşın Nömrəsi</label>
                    <input type="text" value="{{ optional($data)->getAttribute('car_number') }}" name="car_number" class="form-control" id="post-title" placeholder="Enter title">
                    @error('car_number')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-title">Sürücü Adı</label>
                    <input type="text" value="{{ optional($data)->getAttribute('driver_name') }}" name="driver_name" class="form-control" id="post-title" placeholder="Enter title">
                    @error('driver_name')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div> <div class="form-group">
                    <label for="post-title">Sürücü Xərci</label>
                    <input type="text" value="{{ optional($data)->getAttribute('supply_cost') }}" name="driver_cost" class="form-control" id="post-title" placeholder="Enter title">
                    @error('driver_cost')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div> <div class="form-group">
                    <label for="post-title">Maya Dəyəri</label>
                    <input type="text" value="{{ optional($data)->getAttribute('cost') }}" name="cost" class="form-control" id="post-title" placeholder="Enter title">
                    @error('cost')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div> <div class="form-group">
                    <label for="post-title">Gömrük Xərci</label>
                    <input type="text" value="{{ optional($data)->getAttribute('custom_cost') }}" name="custom_cost" class="form-control" id="post-title" placeholder="Enter title">
                    @error('custom_cost')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div> <div class="form-group">
                    <label for="post-title">Bazar Xərci</label>
                    <input type="text" value="{{ optional($data)->getAttribute('market_cost') }}" name="market_cost" class="form-control" id="post-title" placeholder="Enter title">
                    @error('market_cost')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-title">Ümumi Çəkisi</label>
                    <input type="text" value="{{ optional($data)->getAttribute('total_weight') }}" name="total_weight" class="form-control" id="post-title" placeholder="Enter title">
                    @error('total_weight')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-title">Digər Xərc</label>
                    <input type="text" value="{{ optional($data)->getAttribute('other_cost') }}" name="other_cost" class="form-control" id="post-title" placeholder="Enter title"></br></br>
                    @error('other_cost')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                @if ($action)
                    <button type="submit" class="btn btn-primary">Submit</button>
                @endif
            </form>
        </div>
    </main>
@section('script')
    @if (is_null($action))
        <script>
            $('form :input').attr('disabled', true)
        </script>
    @endif
@endsection
@endsection
