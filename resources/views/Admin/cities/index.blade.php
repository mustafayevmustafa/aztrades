@extends('Admin.layout.master')

@section('content')

    <div class="row">
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
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('cities.create')}}">Şəhər Əlavə Et</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                      <table class="table table-responsive-sm">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Şəhər Adı</th>
                            <th scope="col">Tarix</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $city->getAttribute('name') }}</td>
                                <td>{{ $city->getAttribute('created_at') }}</td>
                                <td>
                                    <a href="{{ route('cities.show', $city) }}" class="btn btn-outline-success">Show</a>

                                    <a href="{{ route('cities.edit', $city) }}" class="btn btn-outline-primary">Edit</a>
                                    <button type="button" class="btn btn-outline-danger" onclick="deleteConfirmation({{ $city->getAttribute('id') }}, 'cities')">DELETE</button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                      </table>
                    {{ $cities->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
