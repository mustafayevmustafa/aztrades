@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Ölkələr</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('countries.create')}}">Ölkə Əlavə Et</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
              <table class="table table-responsive">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Ölkə Adı</th>
                        <th scope="col">Tarix</th>
                        <th scope="col">Actions</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($countries as $country)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $country->getAttribute('name') }}</td>
                            <td>{{ $country->getAttribute('created_at') }}</td>
                            <td>
                                <a href="{{ route('countries.show', $country) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                <a href="{{ route('countries.edit', $country) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                <button type="button" class="btn" onclick="deleteConfirmation({{ $country->getAttribute('id') }}, 'countries')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                    {{ $countries->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection
