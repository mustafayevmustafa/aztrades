@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Xərclər</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-3">
                        <a class="btn btn-outline-primary" href="{{route('expenses.index')}}"><i class="mdi mdi-arrow-left"></i></a>
                        @if (is_null($action))
                            <a class="btn btn-outline-primary" href="{{route('expenses.edit', $data)}}">Edit</a>
                        @endif
                    </div>
                    <form action="{{ $action }}" method="POST">
                        @csrf @method($method)

                        <div class="form-group">
                            <label for="">Xərcin növü</label>
                            <select name="expense_type_id" class="form-control">
                                <option value="">Xərcin növünü seçin</option>
                                @foreach($types as $type)
                                    <option value="{{$type->id}}" @if($data->expense_type_id == $type->id) selected @endif>{{$type->name}}</option>
                                @endforeach
                            </select>
                            @error('expense_type_id')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Xərc (AZN)</label>
                            <input type="number" min="0" step=".1" value="{{ $data->getAttribute('expense') }}" name="expense" class="form-control"  placeholder="Xərci daxil edin">
                            @error('expense')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>Qeyd</label>
                            <input type="text" value="{{ $data->getAttribute('note') }}" name="note" class="form-control"  placeholder="Qeyd daxil edin">
                            @error('note')
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