@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Soğanlar</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('onions.create')}}">Soğan Əlavə Et</a>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{route('onions.index')}}">
                        <div class="form-group col-12 col-md-6 p-0">
                            <label for="is-trash-filter">Malin statusu uzre filterle</label>
                            <select class="form-control" id="is-trash-filter" name="status">
                                @foreach($types as $index => $type)
                                    <option value="{{$index}}" @if($status == $index) selected @endif>{{$type}}</option>
                                @endforeach
                            </select>
                        </div>

                        <table class="table table-responsive">
                            <thead>
                            <tr>
                                <th class="text-nowrap" scope="col">#</th>
                                <th class="text-nowrap" scope="col">Şəhər</th>
                                <th class="text-nowrap" scope="col">Kimdən</th>
                                <th class="text-nowrap" scope="col">Maşın Nömrəsi</th>
                                <th class="text-nowrap" scope="col">Tədarük Xərci (AZN)</th>
                                <th class="text-nowrap" scope="col">Maya Dəyəri (AZN)</th>
                                <th class="text-nowrap" scope="col">Çəkisi (kg)</th>
                                <th class="text-nowrap" scope="col">Atxot Mal</th>
                                <th class="text-nowrap" scope="col">Tarix</th>
                                <th class="text-nowrap" scope="col">Əməliyyatlar</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($onions as $onion)
                                <tr>
                                    <td class="text-nowrap">{{ $onion->id }}</td>
                                    <td class="text-nowrap">{{ $onion->getRelationValue('city')->getAttribute('name') }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('from_whom') }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('car_number') }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('supply_cost') }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('cost') }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('total_weight') }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('is_trash') ? 'Bəli' : 'Xeyir' }}</td>
                                    <td class="text-nowrap">{{ $onion->getAttribute('created_at') }}</td>
                                    <td class="text-nowrap">
                                        <a href="{{ route('onions.show', $onion) }}" class="btn p-0 mr-2"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                        <a href="{{ route('onions.edit', $onion) }}" class="btn p-0 mr-2"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                        <button type="button" class="btn btn-link p-0" onclick="deleteConfirmation({{ $onion->getAttribute('id') }}, 'onions')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="15">
                                        <p class="text-danger">No data found</p>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{ $onions->appends(request()->input())->links() }}
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
