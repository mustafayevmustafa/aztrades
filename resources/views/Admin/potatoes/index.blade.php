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
                <div class="card-body" >
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('potatoes.create')}}">Kartof Əlavə Et</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th class="text-nowrap" scope="col">#</th>
                            <th class="text-nowrap" scope="col">Kimdən</th>
                            <th class="text-nowrap" scope="col">Partiyası</th>
                            <th class="text-nowrap" scope="col">Maşın Nömrəsi</th>
                            <th class="text-nowrap" scope="col">Sürücünün Adı</th>
                            <th class="text-nowrap" scope="col">Sürücünün Xərci</th>
                            <th class="text-nowrap" scope="col">Gömrük Xərci</th>
                            <th class="text-nowrap" scope="col">Maya Dəyəri</th>
                            <th class="text-nowrap" scope="col">Bazar Xərci</th>
                            <th class="text-nowrap" scope="col">Digər Xərc</th>
                            <th class="text-nowrap" scope="col">Kisə Sayı</th>
                            <th class="text-nowrap" scope="col">Ümumi Çəkisi</th>
                            <th class="text-nowrap" scope="col">Qiyməti</th>
                            <th class="text-nowrap" scope="col">Yaradılma Tarixi</th>
                            <th class="text-nowrap" scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($potatoes as $potato)
                            <tr>
                                <td class="text-nowrap">{{ $loop->iteration }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('from_whom') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('party') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('car_number') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('driver_name') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('driver_cost') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('cost') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('custom_cost') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('market_cost') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('other_cost') }}</td>
                                <td class="text-nowrap">{{ $potato->getRelationValue('sacs')->getAttribute('sac_count') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('total_weight') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('potato_price') }}</td>
                                <td class="text-nowrap">{{ $potato->getAttribute('created_at') }}</td>
                                <td class="text-nowrap">
                                    <a href="{{ route('potatoes.show', $potato) }}" class="btn btn-link p-0"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('potatoes.edit', $potato) }}" class="btn btn-link p-0"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button onclick="deleteConfirmation({{ $potato->getAttribute('id') }}, 'potatoes')" class="btn btn-link p-0"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
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
