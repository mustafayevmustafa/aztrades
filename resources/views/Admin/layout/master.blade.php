<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>AZTRADE COMPANY SATIŞ MƏRKƏZİ</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @livewireStyles
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Flags Css -->
    <link href="{{ asset('assets/css/flags.css') }}" rel="stylesheet">
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="{{mix('css/app.css')}}">
    <style>
        .pagination {
            justify-content: center;
        }
        p {
            margin-bottom: 0
        }
        img {
            display: block;
        }
    </style>
    @yield('style')
</head>

<body data-layout="detached" data-topbar="colored">

    <div class="container-fluid">
        <div id="layout-wrapper">
            @include('Admin.layout.header')

            @include('Admin.layout.menu')
            <!-- Start Page-content -->
            <div class="main-content">
                <div class="page-content">
                    @yield('content')
                </div>
                @include('Admin.layout.footer')
                <!-- End Page-content -->
            </div>
        </div>
        <div class="rightbar-overlay"></div>
    </div>
        <!-- JAVASCRIPT -->
        <script src="{{ mix('js/app.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/js/app.js') }}"></script>
        <!-- Swal -->
        <script>
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })

            $('input[name="daterange"]').daterangepicker({
                    opens: 'left',
                    locale: {
                        format: "YYYY-MM-DD",
                    },
                }, function (start, end, label) {
                }
            );

            function confirmRequest(url, type = 'POST') {
                Swal.fire({
                    title: "Eminsiniz?",
                    text: "Zəhmət olmasa əmin olun və sonra təsdiq edin!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Beli!",
                    cancelButtonText: "Xeyr!",
                    reverseButtons: !0
                }).then(function(e) {
                    if (e.value === true) {
                        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: type,
                            url: url,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: 'JSON',
                            success: function(results) {
                                if (results.code === 200) {
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                    Swal.fire("Uğurlu!", "", "success");
                                } else {
                                    Swal.fire("Xeta!", "", "error");
                                }
                            },
                            error: function(err) {
                                Swal.fire("Xeta!", "Nəsə xəta baş verdi!", "error");
                            }
                        });

                    } else {
                        e.dismiss;
                    }

                }, function(dismiss) {
                    return false;
                })
            }

            function deleteConfirmation(id, model) {
                Swal.fire({
                    title: "Sil?",
                    text: "Zəhmət olmasa əmin olun və sonra təsdiq edin!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Beli, sil!",
                    cancelButtonText: "Xeyr, silme!",
                    reverseButtons: !0
                }).then(function(e) {
                    if (e.value === true) {
                        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: 'DELETE',
                            url: `/Admin/${model}/${id}`,
                            data: {
                                _token: CSRF_TOKEN
                            },
                            dataType: 'JSON',
                            success: function(results) {
                                if (results.code === 200) {
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000);
                                    Swal.fire("Uğurlu!", "", "success");
                                } else {
                                    Swal.fire("Xeta!", "", "error");
                                }
                            },
                            error: function(err) {
                                Swal.fire("Xeta!", "Nəsə xəta baş verdi!", "error");
                            }
                        });

                    } else {
                        e.dismiss;
                    }

                }, function(dismiss) {
                    return false;
                })
            }
        </script>
        @yield('script')
    @livewireScripts
</body>
</html>
