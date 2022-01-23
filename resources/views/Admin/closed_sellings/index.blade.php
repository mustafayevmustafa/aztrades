@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Ümumi Bağlanan Satışlar</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('сlosed_sellings.index')}}">
                        <div class="row">

                            <div class="form-group col-12 col-md-6">
                                <label for="daterange-filter">Tarixə görə filterlə</label>
                                <input type="text" name="daterange" class="form-control" id="daterange-filter" value="{{request()->get('daterange')}}" readonly>
                            </div>
                            <div class="col-12 my-3">
                                <button type="submit" class="btn btn-outline-primary">Filterlə</button>
                            </div>
                        </div>

                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th>Cibimdəki pul (AZN)</th>
                                <th>Dovriyye (AZN)</th>
                                <th>Borca geden mallar (AZN)</th>
                                <th>Borca aldigim pul (AZN)</th>
                                <th>Borcdan gozlənilən pul (AZN)</th>
                                <th>Xercler (AZN)</th>
                                <th>Tarix</th>
                                <th>Statistika</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($closed_rates as $closed_rate)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{$closed_rate->getAttribute('pocket')}}</td>
                                    <td>{{$closed_rate->getAttribute('turnover')}}</td>
                                    <td>{{$closed_rate->getAttribute('waiting_income_goods')}}</td>
                                    <td>{{$closed_rate->getAttribute('waiting_income_debts')}}</td>
                                    <td>{{$closed_rate->getAttribute('waiting_debts')}}</td>
                                    <td>{{$closed_rate->getAttribute('expenses')}}</td>
                                    <td>{{$closed_rate->getAttribute('created_at')}}</td>
                                    <td>
                                        <a href="{{ route('closed_rates.statistics', ['id' => $closed_rate->id]) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i>Statistika</a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $closed_rates->appends(request()->input())->links() }}
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
