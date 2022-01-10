@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Istifadeciler</h4>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
{{--                        <a class="btn btn-outline-success" href="{{ route('users.create') }}">Istifadeci Əlavə Et</a>--}}
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-responsive">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Istifadeci Adı</th>
                            <th scope="col">Email</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->getAttribute('name') }}</td>
                                <td>{{ $user->getAttribute('email') }}</td>
                                <td>
{{--                                    <a href="{{ route('users.show', $user) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>--}}
{{--                                    <a href="{{ route('users.edit', $user) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>--}}
{{--                                    <button type="button" class="btn" onclick="deleteConfirmation({{ $user->getAttribute('id') }}, 'users')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>--}}
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
                    {{ $users->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>







@endsection
