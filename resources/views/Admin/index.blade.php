@extends('Admin.layout.master')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="page-title mb-0 font-size-18">Satış Səhifəsi</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
{{--                    <h2 class="text-center">Welcome, {{ auth()->user()->getAttribute('name') }}!</h2>--}}
                    <h2 class="text-center">AZTRADE COMPANY SATIŞ MƏRKƏZİ</h2>
                </div>
                <div class="card-body ml-5">
                    <button class="btn btn-primary  btn-lg">Borca Gedən</button>
                    <button class="btn btn-primary  btn-lg">Borcdan Gələn</button>
                    <button class="btn btn-primary  btn-lg">Sklad Xərci</button>
                    <button class="btn btn-primary  btn-lg">Əlavə Xərc</button>
                    <button class="btn btn-primary  btn-lg">Qeyd Yaz</button>
                </div>
                <div class="card-body">
                   <button  type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Sogan Sat</button>
                   <button class="btn btn-success btn-lg">Kartof Sat</button>
                </div>
               <div class="row">
                   <div class="col-6">
                       <table class="table table-bordered">
                           <thead>
                           <tr>
                               <th scope="col">#</th>
                               <th scope="col">Son Satılan Soğanlar</th>
                               <th scope="col">Qalıq</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                               <th scope="row">1</th>
                               <td>10-cu Kamaz 90-BD-921</td>
                               <td>400</td>
                           </tr>
                           </tbody>
                       </table>
                   </div>
                   <div class="col-6">
                       <table class="table table-dark">
                           <thead>
                           <tr>
                               <th scope="col">#</th>
                               <th scope="col">Son Satılan Kartoflar</th>
                               <th scope="col">Qalıq</th>
                           </tr>
                           </thead>
                           <tbody>
                           <tr>
                               <th scope="row">1</th>
                               <td>10-cu Kamaz 90-BD-921</td>
                               <td>400</td>
                           </tr>
                           </tbody>
                       </table>
                   </div>
               </div>
            </div>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                                <label for="exampleFormControlSelect1">Kimdən</label>
                                <select class="form-control" id="exampleFormControlSelect1">
                                    @foreach($onions as $onion)
                                        <option>{{$onion->from_whom}}</option>
                                    @endforeach
                                </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
