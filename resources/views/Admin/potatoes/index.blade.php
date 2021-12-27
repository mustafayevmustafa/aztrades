@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Kartoflar</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('potatoes.create')}}">Kartof Əlavə Et</a>
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
                            <th scope="col">Kimdən</th>
                            <th scope="col">Partiyası</th>
                            <th scope="col">Maşın Nömrəsi</th>
                            <th scope="col">Sürücünün Adı</th>
                            <th scope="col">Sürücünün Xərci</th>
                            <th scope="col">Gömrük Xərci</th>
                            <th scope="col">Maya Dəyəri</th>
                            <th scope="col">Bazar Xərci</th>
                            <th scope="col">Digər Xərc</th>
                            <th scope="col">Ümumi Çəkisi</th>
                            <th scope="col">Qiyməti</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($potatoes as $potato)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $potato->getAttribute('from_whom') }}</td>
                                <td>{{ $potato->getAttribute('party') }}</td>
                                <td>{{ $potato->getAttribute('car_number') }}</td>
                                <td>{{ $potato->getAttribute('driver_name') }}</td>
                                <td>{{ $potato->getAttribute('driver_cost') }}</td>
                                <td>{{ $potato->getAttribute('cost') }}</td>
                                <td>{{ $potato->getAttribute('custom_cost') }}</td>
                                <td>{{ $potato->getAttribute('market_cost') }}</td>
                                <td>{{ $potato->getAttribute('other_cost') }}</td>
                                <td>{{ $potato->getAttribute('total_weight') }}</td>
                                <td>{{ $potato->getAttribute('potato_price') }}</td>
                                <td>
                                    <a href="{{ route('potatoes.show', $potato) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('potatoes.edit', $potato) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button class="btn" onclick="deleteConfirmation({{ $potato->getAttribute('id') }}, 'potatoes')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
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
