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
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">#</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Kimdən</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Maşın Nömrəsi</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Sürücünün Adı</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Tədarük Xərci</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Maya Dəyəri</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Növü</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Qırmızı Kisə Sayı</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Sarı Kisə Sayı</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Lom Kisə Sayı</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Çəkisi</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Qiyməti</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Atxot Mal</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Yaradılma Tarixi</th>
                            <th class="text-nowrap"  class="text-nowrap"scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($onions as $onion)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('from_whom') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('car_number') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('driver_name') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('supply_cost') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('cost') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('type') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('red_bag_number') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('yellow_bag_number') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('lom_bag_number') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('total_weight') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('onion_price') }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('onion_trash')=="0" ? "No" : "Yes" }}</td>
                                <td class="text-nowrap">{{ $onion->getAttribute('created_at') }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('onions.show', $onion) }}" class="btn btn-link p-0"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('onions.edit', $onion) }}" class="btn btn-link p-0"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button class="btn btn-link p-0" onclick="deleteConfirmation({{ $onion->getAttribute('id') }}, 'onions')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
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
