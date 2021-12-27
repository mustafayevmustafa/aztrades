@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Sellings</h4>
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
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf @method($method)
                        @if ($action)
                        @endif
                        <div class="form-group">
                            <label for="post-title">Kimə Satılır</label>
                            <input type="text" value="{{ optional($data)->getAttribute('from_sell') }}" name="from_sell" class="form-control" id="post-title" placeholder="Enter title">
                            @error('from_sell')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Kimdən Alıb</label>
                            <input type="text" value="{{ optional($data)->getAttribute('to_sell') }}" name="to_sell" class="form-control" id="post-title" placeholder="Enter title">
                            @error('to_sell')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Tipi</label>
                            <input type="text" value="{{ optional($data)->getAttribute('type') }}" name="type" class="form-control" id="post-title" placeholder="Enter title">
                            @error('type')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="post-title">Status</label>
                            <input type="text" value="{{ optional($data)->getAttribute('status') }}" name="status" class="form-control" id="post-title" placeholder="Enter title">
                            @error('status')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div> <div class="form-group">
                            <label for="post-title">Qeyd</label>
                            <input type="text" value="{{ optional($data)->getAttribute('content') }}" name="content" class="form-control" id="post-title" placeholder="Enter title">
                            @error('content')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
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
