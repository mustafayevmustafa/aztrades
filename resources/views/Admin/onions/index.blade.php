@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Soğanlar</h4>
            </div>
        </div>
    </div>
    <div class="row mb-3 float-right">
        <div class="col-12">
            <a href="{{ route('onions.create') }}" class="btn btn-outline-success">Soğan Əlavə Et</a>
        </div>
    </div>


    <div class="row">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Kimdən</th>
                <th scope="col">Maşın Nömrəsi</th>
                <th scope="col">Sürücünün Adı</th>
                <th scope="col">Tədarük Xərci</th>
                <th scope="col">Maya Dəyəri</th>
                <th scope="col">Növü</th>
                <th scope="col">Çəkisi</th>
                <th scope="col">Qırmızı Kisə Sayı</th>
                <th scope="col">Sarı Kisə Sayı</th>
                <th scope="col">Lom Kisə Sayı</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($onions as $onion)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $onion->getAttribute('from_whom') }}</td>
                    <td>{{ $onion->getAttribute('car_number') }}</td>
                    <td>{{ $onion->getAttribute('driver_name') }}</td>
                    <td>{{ $onion->getAttribute('supply_cost') }}</td>
                    <td>{{ $onion->getAttribute('cost') }}</td>
                    <td>{{ $onion->getAttribute('type') }}</td>
                    <td>{{ $onion->getAttribute('red_bag_number') }}</td>
                    <td>{{ $onion->getAttribute('yellow_bag_number') }}</td>
                    <td>{{ $onion->getAttribute('lom_bag_number') }}</td>
                    <td>{{ $onion->getAttribute('lom_bag_number') }}</td>
                    <td>
                        <a href="{{ route('onions.show', $onion) }}" class="btn btn-outline-success">Show</a>

                        <a href="{{ route('onions.edit', $onion) }}" class="btn btn-outline-primary">Edit</a>
                        <button class="btn btn-outline-danger" onclick="deleteConfirmation({{ $onion->getAttribute('id') }}, 'onions')">DELETE</button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
