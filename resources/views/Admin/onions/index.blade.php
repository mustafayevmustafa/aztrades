@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Soğanlar</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('onions.create')}}">Soğan Əlavə Et</a>
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
                            <th scope="col">Maşın Nömrəsi</th>
                            <th scope="col">Sürücünün Adı</th>
                            <th scope="col">Tədarük Xərci</th>
                            <th scope="col">Maya Dəyəri</th>
                            <th scope="col">Növü</th>
                            <th scope="col">Qırmızı Kisə Sayı</th>
                            <th scope="col">Sarı Kisə Sayı</th>
                            <th scope="col">Lom Kisə Sayı</th>
                            <th scope="col">Çəkisi</th>
                            <th scope="col">Qiyməti</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($onions as $onion)
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
                                <td>{{ $onion->getAttribute('total_weight') }}</td>
                                <td>{{ $onion->getAttribute('onion_price') }}</td>
                                <td>
                                    <a href="{{ route('onions.show', $onion) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('onions.edit', $onion) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button class="btn" onclick="deleteConfirmation({{ $onion->getAttribute('id') }}, 'onions')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
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
