@extends('Admin.layout.master')

@section('content')
    <div class="row" xmlns:x-forms="http://www.w3.org/1999/html">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Xərclər | Borclar</h4>
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

                        @if(!is_null($action))
                            <input type="hidden" name="back" value="{{$back}}">
                        @endif

                        <div class="form-group">
                            <label>Musteri</label>
                            <input type="text" value="{{ $data->getAttribute('customer') }}" name="customer" class="form-control"  placeholder="Musterini daxil edin">
                            @error('customer')
                            <p class="text-danger">
                                {{ $message }}
                            </p>
                            @enderror
                        </div>

                        @if($data->getAttribute('expense_type_id') == \App\Models\ExpensesType::debt || request()->get('type') == \App\Models\ExpensesType::debt)
                            <input type="hidden" name="expense_type_id" value="{{\App\Models\ExpensesType::debt}}">
                        @else
                            <div class="form-group">
                                <label for="">Xərcin növü</label>
                                <select name="expense_type_id" class="form-control">
                                    <option value="">Xərcin növünü seçin</option>
                                    @foreach($types as $key => $id)
                                        <option value="{{$id}}" @if($data->getAttribute('expense_type_id') == $id || request()->get('type') == $id) selected @endif>@lang('translates.expenseTypes.' . $id)</option>
                                    @endforeach
                                </select>
                                @error('expense_type_id')
                                <p class="text-danger">
                                    {{ $message }}
                                </p>
                                @enderror
                            </div>
                        @endif

                        <div class="form-group">
                            <label>@if($data->getAttribute('expense_type_id') == \App\Models\ExpensesType::debt || request()->get('type') == \App\Models\ExpensesType::debt) Borc (AZN) @else Xərc (AZN) @endif</label>
                            <input type="number" min="0" step=".1" value="{{ $data->getAttribute('expense') }}" name="expense" class="form-control"  placeholder="Qiymeti daxil edin">
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

                        @if($method == 'POST' && request()->has('is_income'))
                            <input type="hidden" name="is_income" value="{{request()->has('is_income')}}">
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
