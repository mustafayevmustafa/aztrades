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

    <!-- SweetAlert2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
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

            function deleteConfirmation(id, model) {
                swal({
                    title: "Delete?",
                    text: "Please ensure and then confirm!",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Yes, delete it!",
                    cancelButtonText: "No, cancel!",
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
                                    swal("Done!", "", "success");
                                } else {
                                    swal("Error!", "", "error");
                                }
                            },
                            error: function(err) {
                                swal("Error!", "Something went wrong!", "error");
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
