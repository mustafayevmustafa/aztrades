@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Ölkələr</h4>
            </div>
        </div>
    </div>
    <div class="row mb-3 float-right">
        <div class="col-12">
            <a href="{{ route('countries.create') }}" class="btn btn-outline-success">Ölkə Əlavə Et</a>
        </div>
    </div>


    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Ölkə Adı</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($countries as $country)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $country->getAttribute('name') }}</td>
                    <td>
                        <a href="{{ route('countries.show', $country) }}" class="btn btn-outline-success">Show</a>

                        <a href="{{ route('countries.edit', $country) }}" class="btn btn-outline-primary">Edit</a>
                        <button class="btn btn-outline-danger" onclick="deleteConfirmation({{ $country->getAttribute('id') }}, 'countries')">DELETE</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
