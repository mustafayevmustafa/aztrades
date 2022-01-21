@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Qeydlər</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('notes.create')}}">Qeyd Əlavə Et</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="table-responsive">

                    <table class="table  w-100">
                        <thead>
                        <tr>
                            <th >#</th>
                            <th>Qeyd</th>
                            <th >Tarix</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($notes as $note)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $note->getAttribute('note') }}</td>
                                <td>{{ $note->getAttribute('created_at') }}</td>
                                <td>
                                    <a href="{{ route('notes.show', $note) }}" class="btn"><i class="mdi mdi-18px mdi-eye" style="color: blue"></i></a>
                                    <a href="{{ route('notes.edit', $note) }}" class="btn"><i class="mdi mdi-18px mdi-pencil-circle" style="color: blue"></i></a>
                                    <button type="button" class="btn" onclick="deleteConfirmation({{ $note->getAttribute('id') }}, 'notes')"> <i style="color:red" class="mdi mdi-18px mdi-close-circle"></i></button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    </div>
                    {{ $notes->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

