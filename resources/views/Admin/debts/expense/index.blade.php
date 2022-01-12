@extends('Admin.layout.master')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Borca geden</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('expenses.create', ['type' => \App\Models\ExpensesType::debt])}}">Borc Əlavə Et</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('debts.expense')}}">
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="daterange-filter">Tarixə görə filterlə</label>
                                <input type="text" name="daterange" class="form-control" id="daterange-filter" value="{{request()->get('daterange')}}" readonly>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="note-filter">Qeyde görə filterlə</label>
                                <input type="text" name="note" class="form-control" id="note-filter" value="{{request()->get('note')}}">
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="customer-filter">Musteriye görə filterlə</label>
                                <input type="text" name="customer" class="form-control" id="customer-filter" value="{{request()->get('customer')}}">
                            </div>

                            <div class="col-12 my-3">
                                <button type="submit" class="btn btn-outline-primary">Filterlə</button>
                            </div>
                        </div>

                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Musteri</th>
                                <th scope="col">Borcun növu</th>
                                <th scope="col">Borc malın növu</th>
                                <th scope="col">Qeyd</th>
                                <th scope="col">Borc (AZN)</th>
                                <th scope="col">Tarix</th>
                                <th scope="col">Əməliyyatlar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($expenses as $expense)
                                <tr @if($expense->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $expense->getAttribute('customer') }}</td>
                                    <td>{{ $expense->goodsType()->exists() ? ($expense->getRelationValue('goodsType')->getTable() == 'onions' ? 'Soğan' : 'Kartof') : 'Digər' }}</td>
                                    <td>{{ $expense->goodsType()->exists() ? $expense->getRelationValue('goodsType')->getAttribute('info') : 'Digər'}}</td>
                                    <td>{{ $expense->getAttribute('note') }}</td>
                                    <td>{{ $expense->getAttribute('expense') }}</td>
                                    <td>{{ $expense->getAttribute('created_at') }}</td>
                                    <td>
                                        <a href="{{ route('expenses.show', $expense) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                        @if (is_null($expense->getAttribute('goods_type')))
{{--                                            <a href="{{ route('expenses.edit', $expense) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>--}}
                                        @endif
                                        <button type="button" class="btn" onclick="deleteConfirmation({{ $expense->getAttribute('id') }}, 'expenses')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $expenses->appends(request()->input())->links() }}
                    </form>
              </div>
          </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('select').change(function (){
            this.form.submit();
        });
    </script>
@endsection
