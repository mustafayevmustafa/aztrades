@extends('Admin.layout.master')

@section('content')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
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
                    <p>ss</p>
                    <table class="table table-responsive-sm" id="myTable">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Kimə Satılıb</th>
                            <th scope="col">Tipi</th>
                            <th scope="col">Status</th>
                            <th scope="col">Qiyməti</th>
                            <th scope="col">Qeyd</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($sellings as $selling)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $selling->getAttribute('customer') }}</td>
                                <td>{{ $selling->getAttribute('type')== 'onion' ? "Soğan" : "Kartof" }}</td>
                                <td>{{ $selling->getAttribute('status') == 0 ? "Nagd" : "Borc" }}</td>
                                <td>{{ $selling->getAttribute('price')}}</td>
                                <td>{{ $selling->getAttribute('content') }}</td>
                                <td>
                                    <a href="{{ route('sellings.show', $selling) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('sellings.edit', $selling) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button class="btn" onclick="deleteConfirmation({{ $selling->getAttribute('id') }}, 'sellings')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="3">
                                    <p class="text-danger text-center">No data found</p>
                                </th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.js"></script>

@endsection
@section('script')
    <script>
        $(document).ready( function () {
            $('#myTable').DataTable();
        } );
    </script>
@endsection
