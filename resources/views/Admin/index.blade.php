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

                    <div id="buttons" class="mt-4">
                        @can('disable')
                            <button type="button" class="btn @if($setting->getAttribute('is_active')) btn-outline-danger @else btn-outline-success @endif" onclick="confirmRequest('{{route('settings.toggle-state')}}')">Satışı @if($setting->getAttribute('is_active')) bağla @else aç @endif</button>
                        @endcan
                        <button class="btn btn-outline-primary" id="show-statistics">Statistika</button>
                        <button class="btn btn-outline-info" id="show-closed-rates">Baglanan satislar</button>
                    </div>

                    <div id="closed-rates" class="d-none text-center my-4">
                        <h4 class="font-weight-bold">Baglanan satislar</h4>
                        <table class="table table-responsive table-bordered my-4">
                            <thead>
                                <tr>
                                    <th>Cibimdəki pul (AZN)</th>
                                    <th>Dovriyye (AZN)</th>
                                    <th>Borca geden mallar (AZN)</th>
                                    <th>Borca aldigim pul (AZN)</th>
                                    <th>Borcdan gozlənilən pul (AZN)</th>
                                    <th>Xercler (AZN)</th>
                                    <th>Tarix</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($closed_rates as $closed_rate)
                                <tr>
                                    <td>{{$closed_rate->getAttribute('pocket')}}</td>
                                    <td>{{$closed_rate->getAttribute('turnover')}}</td>
                                    <td>{{$closed_rate->getAttribute('waiting_income_goods')}}</td>
                                    <td>{{$closed_rate->getAttribute('waiting_income_debts')}}</td>
                                    <td>{{$closed_rate->getAttribute('waiting_debts')}}</td>
                                    <td>{{$closed_rate->getAttribute('expenses')}}</td>
                                    <td>{{$closed_rate->getAttribute('created_at')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div id="statistics" class="d-none text-center">
                        <div class="my-4">
                            <h4 class="font-weight-bold">Hazir ki veziyyet</h4>
                            <div class="row text-center m-0 my-4">
                                <div class="col-6 col-md-4 my-2">
                                    <h5 class="card-title">Cibimdəki pul</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_net_income}} AZN</p>
                                </div>

                                <div class="col-6 col-md-4 my-2">
                                    <h5 class="card-title">Dovriyye</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_income}} AZN</p>
                                </div>

                                <div class="col-6 col-md-4 my-2">
                                    <h5 class="card-title">Borca geden mallar</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_waiting_income_goods}} AZN</p>
                                </div>

                                <div class="col-6 col-md-4 my-2">
                                    <h5 class="card-title">Borcdan gelen pul</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_waiting_income_debt}} AZN</p>
                                </div>

                               <div class="col-6 col-md-4 my-2">
                                    <h5 class="card-title">Borca geden pul</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_waiting_income}} AZN</p>
                                </div>

                                <div class="col-6 col-md-4 my-2">
                                    <h5 class="card-title">Xercler</h5>
                                    <p class="card-text" style="font-size: 16px">{{$daily_expense}} AZN</p>
                                </div>
                            </div>
                        </div>
                        <div class="my-4">
                            <h4 class="font-weight-bold">Aylıq</h4>
                            <div class="row text-center m-0 my-4">
                                <div class="col-6">
                                    <h5 class="card-title">Dovriyye</h5>
                                    <p class="card-text" style="font-size: 16px">{{$monthly_income}} AZN</p>
                                </div>

                                <div class="col-6">
                                    <h5 class="card-title">Xercler</h5>
                                    <p class="card-text" style="font-size: 16px">{{$monthly_expense}} AZN</p>
                                </div>
                            </div>
                        </div>

                        <div class="my-4">
                            <h4 class="font-weight-bold">Ümumi</h4>
                            <div class="row text-center m-0 my-4">
                                <div class="col-6">
                                    <h5 class="card-title">Dovriyye</h5>
                                    <p class="card-text" style="font-size: 16px">{{$total_income}} AZN</p>
                                </div>

                                <div class="col-6">
                                    <h5 class="card-title">Xercler</h5>
                                    <p class="card-text" style="font-size: 16px">{{$total_expense}} AZN</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 d-flex flex-md-nowrap flex-wrap justify-content-between">
                    <a href="{{route('debts.expense')}}" class="btn btn-danger mt-md-0 mx-2 ml-0 btn-block">Borca Gedən</a>
                    <a href="{{route('debts.income')}}" class="btn btn-warning mt-md-0 mx-2 btn-block">Borcdan Gələn</a>
                    <a href="{{route('expenses.index', ['expense_type_id' => \App\Models\ExpensesType::warehouse_cost])}}" class="btn btn-primary mt-md-0 mx-2 btn-block">Sklad Xərci</a>
                    <a href="{{route('expenses.index', ['all_except' => \App\Models\ExpensesType::warehouse_cost])}}" class="btn btn-secondary mt-md-0 mx-2 btn-block">Digər Xərc</a>
                    <a href="{{route('notes.create')}}" class="btn btn-info mt-md-0 mx-2 btn-block">Qeyd Yaz</a>
                </div>

                @if($setting->getAttribute('is_active'))
                    <div class="card-body px-0 d-flex flex-md-nowrap flex-wrap">
                        <button  type="button" class="btn btn-success btn-block mt-md-0 mx-2 ml-0" data-toggle="modal" data-target="#exampleModal">Sogan Sat</button>
                        <button  type="button" class="btn btn-success btn-block mt-md-0 mx-2 ml-0" data-toggle="modal" data-target="#ModalPotato">Kartof Sat</button>
                    </div>
                @endif

                <div class="card-body row m-0 p-0">
                    <div class="col-12 col-xl-5 p-0">
                        <table class="table table-success table-responsive text-dark">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Son Satılan Soğanlar</th>
                                <th scope="col">Qırmızı Kisə Sayı</th>
                                <th scope="col">Sarı Kisə Sayı</th>
                                <th scope="col">Lom Kisə Sayı</th>
                                <th scope="col">Çəki (kq)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($onions->slice(0,5) as $onion)
                                <tr>
                                    <th>{{$onion->getAttribute('id')}}</th>
                                    <th>
                                        <a class="text-dark @if(!$setting->getAttribute('is_active')) disabled @endif"  href="{{route('sellings.create', ['type_id' => $onion->getAttribute('id'), 'type' => 'onion'])}}">
                                            {{$onion->getAttribute('info')}}
                                        </a>
                                    </th>
                                    <th>{{$onion->getAttribute('red_bag_number')}}</th>
                                    <th>{{$onion->getAttribute('yellow_bag_number')}}</th>
                                    <th>{{$onion->getAttribute('lom_bag_number')}}</th>
                                    <th>{{$onion->getAttribute('total_weight')}}</th>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 col-xl-7 p-0 pl-1">
                        <table class="table table-secondary table-responsive-sm">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Son Satılan Kartoflar</th>
                                <th scope="col">Kisə Sayı</th>
                                <th scope="col">Çəki (kq)</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($potatoes->slice(0,5) as $potato)
                                    <tr>
                                        <th scope="row">{{$potato->getAttribute('id')}}</th>
                                        <td>
                                            <a class="text-dark @if(!$setting->getAttribute('is_active')) disabled @endif" href="{{route('sellings.create', ['type_id' => $potato->getAttribute('id'), 'type' => 'potato'])}}">
                                                {{$potato->getAttribute('info')}}
                                            </a>
                                        </td>
                                        <td>
                                            <table>
                                                <tr>
                                                    <td>Adi</td>
                                                    <td>Sayi</td>
                                                    <td>Kisə həcmi (kg)</td>
                                                    <td>Qaliq həcm (kg)</td>
                                                </tr>
                                                @foreach($potato->sacs as $sac)
                                                    <tr>
                                                        <td>{{$sac->name}}</td>
                                                        <td>{{$sac->sac_count}}</td>
                                                        <td>{{$sac->sac_weight}}</td>
                                                        <td>{{$sac->total_weight}}</td>
                                                    </tr>
                                                @endforeach
                                            </table>
                                        </td>
                                        <td>{{$potato->getAttribute('total_weight')}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-12 text-right">
                    <h5 class="card-title text-danger">Cibimdəki Pul</h5>
                    <p class="card-text" style="font-size: 16px">{{$daily_net_income}} AZN</p>
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

        $('#show-closed-rates').click(function (){
            $('#closed-rates').toggleClass('d-none');
        });
    </script>
@endsection
