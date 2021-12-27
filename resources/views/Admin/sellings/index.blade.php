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
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{ route('sellings.create') }}">Satış Əlavə Et</a>
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
                            <th scope="col">Kimə Satılır</th>
                            <th scope="col">Kimdən Alıb</th>
                            <th scope="col">Tipi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Qeyd</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sellings as $selling)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $selling->getAttribute('from_sell') }}</td>
                                <td>{{ $selling->getAttribute('to_sell') }}</td>
                                <td>{{ $selling->getAttribute('type') }}</td>
                                <td>{{ $selling->getAttribute('status') }}</td>
                                <td>{{ $selling->getAttribute('content') }}</td>
                                <td>
                                    <a href="{{ route('sellings.show', $selling) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('sellings.edit', $selling) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button class="btn" onclick="deleteConfirmation({{ $onion->getAttribute('id') }}, 'sellings')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="3">
                                    <p class="text-danger">No data found</p>
                                </th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>







@endsection
