@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Şəhərlər</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-outline-primary" href="{{route('cities.index')}}"><i class="mdi mdi-arrow-left"></i></a>
                        @if (is_null($action))
                            <a class="btn btn-outline-primary" href="{{route('cities.edit', $data)}}">Editle</a>
                        @endif

                    </div>
                    <form action="{{ $action }}" method="POST" enctype="multipart/form-data">
                        @csrf @method($method)

                        <div class="form-group">
                            <label for="post-title">Şəhər Adı</label>
                            <input type="text" value="{{ optional($data)->getAttribute('name') }}" name="name" class="form-control" id="post-title" placeholder="Ölkə Adı Daxil Edin">
                            @error('name')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

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
