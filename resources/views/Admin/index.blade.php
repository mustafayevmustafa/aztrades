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
                <div class="card-body px-2">
                    <h3 class="text-center">AZTRADE COMPANY SATIŞ MƏRKƏZİ</h3>
                    <button class="btn btn-outline-primary" id="show-statistics">Statistikanı görsət</button>
                    <div id="statistics" class="d-none text-center">
                        <div class="my-4">
                            <h4>Günlük</h4>
                            <div class="row text-center m-0 my-4">
                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Net gelir</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_net_income}} AZN</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Gozlenilen gelir</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_waiting_income}} AZN</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Xercler</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_expense}} AZN</p>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <h4>Aylıq</h4>
                            <div class="row text-center m-0 my-4">
                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Net gelir</h5>
                                    <p class="card-text" style="font-size: 16px">{{$monthly_net_income}} AZN</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Gozlenilen gelir</h5>
                                    <p class="card-text" style="font-size: 16px">{{$monthly_waiting_income}} AZN</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Xercler</h5>
                                    <p class="card-text" style="font-size: 16px">{{$monthly_expense}} AZN</p>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <h4>Ümumi</h4>
                            <div class="row text-center m-0 my-4">
                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Net gelir</h5>
                                    <p class="card-text" style="font-size: 16px">{{$net_income}} AZN</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Gozlenilen gelir</h5>
                                    <p class="card-text" style="font-size: 16px">{{$waiting_income}} AZN</p>
                                </div>

                                <div class="col-12 col-md-4">
                                    <h5 class="card-title">Xercler</h5>
                                    <p class="card-text" style="font-size: 16px">{{$expense}} AZN</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 d-flex flex-md-nowrap flex-wrap justify-content-between">
                    <button class="btn btn-primary mt-md-0 mx-2 ml-0 btn-block">Borca Gedən</button>
                    <button class="btn btn-primary mt-md-0 mx-2 btn-block">Borcdan Gələn</button>
                    <button class="btn btn-primary mt-md-0 mx-2 btn-block">Sklad Xərci</button>
                    <button class="btn btn-primary mt-md-0 mx-2 btn-block">Əlavə Xərc</button>
                </div>
                <div class="card-body px-0 d-flex flex-md-nowrap flex-wrap">
                    <button  type="button" class="btn btn-success btn-block mt-md-0 mx-2 ml-0" data-toggle="modal" data-target="#exampleModal">Sogan Sat</button>
                    <button  type="button" class="btn btn-success btn-block mt-md-0 mx-2 ml-0" data-toggle="modal" data-target="#ModalPotato">Kartof Sat</button>
                </div>
                <div class="card-body row d-flex flex-md-nowrap flex-wrap">
                    <table class="table mx-2 ml-0 table-dark">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Son Alınan Soğanlar</th>
                            <th scope="col">Qalıq Çəki (kq)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($onions as $onion)
                            <tr>
                                <th>{{$onion->getAttribute('id')}}</th>
                                <th>{{$onion->getAttribute('info')}}</th>
                                <th>{{$onion->getAttribute('total_weight')}}</th>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                    <table class="table mx-2 mr-0 table-dark">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Son Alınan Kartoflar</th>
                            <th scope="col">Qalıq Çəki (kq)</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($potatoes as $potato)
                            <tr>
                                <th scope="row">{{$potato->getAttribute('id')}}</th>
                                <td>{{$potato->getAttribute('info')}}</td>
                                <td>{{$potato->getAttribute('total_weight')}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Soğan Satışı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('sellings.create')}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kimdən</label>
                                <select name="type_id" class="form-control" id="exampleFormControlSelect1">
                                    @foreach($onions as $onion)
                                        <option value="{{$onion->id}}">{{$onion->getAttribute('info')}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="onion" name="type">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                            <button type="submit" class="btn btn-primary">Sat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="modal fade" id="ModalPotato" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Kartof Satışı</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{route('sellings.create')}}">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">Kimdən</label>
                                <select name="type_id" class="form-control" id="exampleFormControlSelect1">
                                    @foreach($potatoes as $potato)
                                        <option value="{{$potato->id}}">{{$potato->getAttribute('info')}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" value="potato" name="type">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Bağla</button>
                            <button type="submit" class="btn btn-primary">Sat</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('#show-statistics').click(function (){
            $('#statistics').toggleClass('d-none');
        });
    </script>
@endsection
