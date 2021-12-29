@extends('Admin.layout.master')

@section('content')


    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Xərclər</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-3">
                        <a class="btn btn-outline-success" href="{{route('expenses.create')}}">Xərc Əlavə Et</a>
                    </div>
                    @if (session('success'))
                        <div class="alert alert-success mt-2">
                            {{ session('success') }}
                        </div>
                    @endif
              <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Xərcin növu</th>
                    <th scope="col">Xərcin malın növu</th>
                    <th scope="col">Xərcin malı</th>
                    <th scope="col">Qeyd</th>
                    <th scope="col">Xərc (AZN)</th>
                    <th scope="col">Tarix</th>
                    <th scope="col">Əməliyyatlar</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->getRelationValue('type')->getAttribute('name') }}</td>
                        <td>{{ $expense->goodsType()->exists() ? ($expense->getRelationValue('goodsType')->getTable() == 'onions' ? 'Soğan' : 'Kartof') : 'Digər' }}</td>
                        <td>{{ $expense->goodsType()->exists() ? $expense->getRelationValue('goodsType')->getAttribute('info') : 'Digər'}}</td>
                        <td>{{ $expense->getAttribute('note') }}</td>
                        <td>{{ $expense->getAttribute('expense') }}</td>
                        <td>{{ $expense->getAttribute('created_at') }}</td>
                        <td>
                            <a href="{{ route('expenses.show', $expense) }}" class="btn btn-outline-success">Show</a>
                            <a href="{{ route('expenses.edit', $expense) }}" class="btn btn-outline-primary">Edit</a>
                            <button class="btn btn-outline-danger" onclick="deleteConfirmation({{ $expense->getAttribute('id') }}, 'expenses')">DELETE</button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
    </div>
@endsection