@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Satışlar</h4>
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

                    <form action="{{route('sellings.index')}}">
                        <div class="row">
                            <div class="form-group col-12 col-md-6">
                                <label for="is-trash-filter">Gəlir növünə görə filterlə</label>
                                <select class="form-control" id="is-trash-filter" name="type">
                                    <option value="">Növü seç</option>
                                    @foreach($types as $index => $_type)
                                        <option value="{{$index}}" @if($index === (int) request()->get('type') && is_numeric(request()->get('type'))) selected @endif>{{$_type}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-12 col-md-6">
                                <label for="daterange-filter">Tarixə görə filterlə</label>
                                <input type="text" name="daterange" class="form-control" id="daterange-filter" value="{{request()->get('daterange')}}" readonly>
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
                                <th scope="col">Kimə Satılıb</th>
                                <th scope="col">Malin növü</th>
                                <th scope="col">Mal</th>
                                <th scope="col">Status</th>
                                <th scope="col">Qiymət (AZN)</th>
                                <th scope="col">Ceki (kg)</th>
                                <th scope="col">Kise</th>
                                <th scope="col">Kise sayi</th>
                                <th scope="col">Qeyd</th>
                                <th scope="col">Tarix</th>
                                <th scope="col">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($sellings as $selling)
                                <tr @if($selling->getAttribute('closed_rate_id')) style="background-color: #adcee8" @endif>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $selling->getAttribute('customer') }}</td>
                                    <td>{{ $selling->getAttribute('type') == 'onion' ? "Soğan" : "Kartof" }}</td>
                                    <td>{{ $selling->getAttribute('sellingable')->getAttribute('info') }}</td>
                                    <td>{{ $selling->getAttribute('was_debt') ? "Borc" : "Nagd" }}</td>
                                    <td>{{ $selling->getAttribute('price')}}</td>
                                    <td>{{ $selling->getAttribute('weight')}}</td>
                                    <td>{{ $selling->getAttribute('type') == 'onion' ? \App\Models\Onion::bags()[$selling->getAttribute('sac_name')] ?? 'Yoxdur' : optional(\App\Models\PotatoSac::find($selling->getAttribute('sac_name')))->getAttribute('name') ?? '' }}</td>
                                    <td>{{ $selling->getAttribute('sac_count')}}</td>
                                    <td>{{ $selling->getAttribute('content') }}</td>
                                    <td>{{ $selling->getAttribute('created_at') }}</td>
                                    <td>
                                        <a href="{{ route('sellings.show', $selling) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                        {{--                                    <a href="{{ route('sellings.edit', $selling) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>--}}
                                        <button type="button" class="btn" onclick="deleteConfirmation({{ $selling->getAttribute('id') }}, 'sellings')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12">
                                        <p class="text-danger text-center">No data found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $sellings->appends(request()->input())->links() }}
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
