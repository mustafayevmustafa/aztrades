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
                    <input type="text" value="{{ optional($data)->getAttribute('name') }}" name="name" class="form-control" id="post-title" placeholder="Enter title">
                    @error('name')
                    <p class="text-danger">
                        {{ $message }}
                    </p>
                    @enderror
                </div>
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
