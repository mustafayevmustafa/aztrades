@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Borclar</h4>
            </div>
        </div>
    </div>
    <div class="row mb-3 float-right">
        <div class="col-12">
            <a href="{{ route('sellings.create') }}" class="btn btn-outline-success">Satış Əlavə Et</a>
        </div>
    </div>


    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kimə Satılır</th>
                <th scope="col">Kimdən Alıb</th>
                <th scope="col">Tipi</th>
                <th scope="col">Status</th>
                <th scope="col">Qeyd</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($sellings as $selling)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $selling->getAttribute('from_sell') }}</td>
                    <td>{{ $selling->getAttribute('to_sell') }}</td>
                    <td>{{ $selling->getAttribute('type') }}</td>
                    <td>{{ $selling->getAttribute('status') }}</td>
                    <td>{{ $selling->getAttribute('content') }}</td>
                    <td>
                        <a href="{{ route('sellings.show', $selling) }}" class="btn btn-outline-success">Show</a>

                        <a href="{{ route('sellings.edit', $selling) }}" class="btn btn-outline-primary">Edit</a>
                        <button class="btn btn-outline-danger" onclick="deleteConfirmation({{ $selling->getAttribute('id') }}, 'sellings')">DELETE</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
