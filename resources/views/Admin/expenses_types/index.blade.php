@extends('Admin.layout.master')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Xərclərin Tipi</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
{{--                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">--}}
{{--                        <a class="btn btn-outline-success" href="{{route('expenses_types.create')}}">Xərclərin Tipi Əlavə Et</a>--}}
{{--                    </div>--}}
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
              <table class="table table-responsive">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Xərclərin Tipinin adı</th>
                    <th scope="col">Xərclərin Tipinin acarı</th>
                    <th scope="col">Tarix</th>
                    <th scope="col">Əməliyyatlar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($expenses_types as $type)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $type->getAttribute('name') }}</td>
                        <td>{{ $type->getAttribute('key') }}</td>
                        <td>{{ $type->getAttribute('created_at') }}</td>
                        <td>
                            <a href="{{ route('expenses_types.show', $type) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
{{--                            <a href="{{ route('expenses_types.edit', $type) }}" class="btn btn-outline-primary">Editle</a>--}}
{{--                            <button type="button" class="btn btn-outline-danger" onclick="deleteConfirmation({{ $type->getAttribute('id') }}, 'expenses_types')">DELETE</button>--}}
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
                    {{ $expenses_types->appends(request()->input())->links() }}
                </div>
          </div>
        </div>
    </div>
@endsection
