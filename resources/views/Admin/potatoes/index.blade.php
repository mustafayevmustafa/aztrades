@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Kartoflar</h4>
            </div>
        </div>
    </div>
    <div class="row mb-3 float-right">
        <div class="col-12">
            <a href="{{ route('potatoes.create') }}" class="btn btn-outline-success">Kartof Əlavə Et</a>
        </div>
    </div>


    <div class="row">
        <table class="table">
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
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($potatoes as $potato)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $potato->getAttribute('from_whom') }}</td>
                    <td>{{ $potato->getAttribute('car_number') }}</td>
                    <td>{{ $potato->getAttribute('driver_name') }}</td>
                    <td>{{ $potato->getAttribute('driver_cost') }}</td>
                    <td>{{ $potato->getAttribute('cost') }}</td>
                    <td>{{ $potato->getAttribute('custom_cost') }}</td>
                    <td>{{ $potato->getAttribute('market_cost') }}</td>
                    <td>{{ $potato->getAttribute('other_cost') }}</td>
                    <td>{{ $potato->getAttribute('total_weight') }}</td>
                    <td>{{ $potato->getAttribute('total_weight') }}</td>
                    <td>
                        <a href="{{ route('potatoes.show', $potato) }}" class="btn btn-outline-success">Show</a>

                        <a href="{{ route('potatoes.edit', $potato) }}" class="btn btn-outline-primary">Edit</a>
                        <button class="btn btn-outline-danger" onclick="deleteConfirmation({{ $potato->getAttribute('id') }}, 'potatoes')">DELETE</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
