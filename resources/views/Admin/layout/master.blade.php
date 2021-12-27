<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Admin Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
{{--    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('') }}">--}}
{{--    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('') }}">--}}
{{--    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('') }}">--}}
{{--    <link rel="mask-icon" href="{{ asset('') }}" color="#5bbad5">    <!-- csrf-token -->--}}
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
    <!-- TinyMCE -->
    <script src="https://cdn.tiny.cloud/1/6hi4bok2utssc8368iz75o1mg2sma3bl46qf41q4i2ah6myx/tinymce/5/tinymce.min.js"
        referrerpolicy="origin"></script>
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.2.0/sweetalert2.all.min.js"></script>
    <script>
        tinymce.init({
            selector: '.tinyMCE',
            readonly: {{ str_contains(url()->current(), '/create') ||
            str_contains(url()->current(), '/edit') ||
            auth()->user()->cannot('update')
                ? '0'
                : '1' }},
            height: 500,
            plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
            imagetools_cors_hosts: ['picsum.photos'],
            menubar: 'file edit view insert format tools table help',
            toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent |  numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen  preview save print | insertfile image media template link anchor codesample | ltr rtl',
            toolbar_sticky: true,
            autosave_ask_before_unload: true,
            autosave_interval: '30s',
            autosave_prefix: '{path}{query}-{id}-',
            autosave_restore_when_empty: false,
            autosave_retention: '2m',
            image_advtab: true,
            link_list: [{
                    title: 'My page 1',
                    value: 'https://www.tiny.cloud'
                },
                {
                    title: 'My page 2',
                    value: 'http://www.moxiecode.com'
                }
            ],
            image_list: [{
                    title: 'My page 1',
                    value: 'https://www.tiny.cloud'
                },
                {
                    title: 'My page 2',
                    value: 'http://www.moxiecode.com'
                }
            ],
            image_class_list: [{
                    title: 'None',
                    value: ''
                },
                {
                    title: 'Some class',
                    value: 'class-name'
                }
            ],
            importcss_append: true,
            image_title: true,
            automatic_uploads: true,
            file_picker_types: 'image',
            images_upload_handler: function (blobInfo, success, failure) {
                var xhr, formData;
                xhr = new XMLHttpRequest();
                xhr.withCredentials = false;
                xhr.open('POST', '/image/uploads');
                var token = '{{ csrf_token() }}';
                xhr.setRequestHeader("X-CSRF-Token", token);
                xhr.onload = function() {
                    var json;
                    if (xhr.status != 200) {
                        failure('HTTP Error: ' + xhr.status);
                        return;
                    }
                    json = JSON.parse(xhr.responseText);

                    if (!json || typeof json.location != 'string') {
                        failure('Invalid JSON: ' + xhr.responseText);
                        return;
                    }
                    success(json.location);
                };
                formData = new FormData();
                formData.append('file', blobInfo.blob(), blobInfo.filename());
                xhr.send(formData);
            },
            file_picker_callback: function(callback, value, meta) {
                /* Provide file and text for the link dialog */
                if (meta.filetype === 'file') {
                    callback('https://www.google.com/logos/google.jpg', {
                        text: 'My text'
                    });
                }

                /* Provide image and alt text for the image dialog */
                if (meta.filetype === 'image') {
                    callback('https://www.google.com/logos/google.jpg', {
                        alt: 'My alt text'
                    });
                }

                /* Provide alternative source and posted for the media dialog */
                if (meta.filetype === 'media') {
                    callback('movie.mp4', {
                        source2: 'alt.ogg',
                        poster: 'https://www.google.com/logos/google.jpg'
                    });
                }
            },
            templates: [{
                    title: 'New Table',
                    description: 'creates a new table',
                    content: '<div class="mceTmpl"><table width="98%%"  border="0" cellspacing="0" cellpadding="0"><tr><th scope="col"> </th><th scope="col"> </th></tr><tr><td> </td><td> </td></tr></table></div>'
                },
                {
                    title: 'Starting my story',
                    description: 'A cure for writers block',
                    content: 'Once upon a time...'
                },
                {
                    title: 'New list with dates',
                    description: 'New List with dates',
                    content: '<div class="mceTmpl"><span class="cdate">cdate</span><br /><span class="mdate">mdate</span><h2>My List</h2><ul><li></li><li></li></ul></div>'
                }
            ],
            template_cdate_format: '[Date Created (CDATE): %m/%d/%Y : %H:%M:%S]',
            template_mdate_format: '[Date Modified (MDATE): %m/%d/%Y : %H:%M:%S]',
            image_caption: true,
            quickbars_selection_toolbar: 'bold italic | quicklink h2 h3 blockquote quickimage quicktable',
            noneditable_noneditable_class: 'mceNonEditable',
            toolbar_mode: 'sliding',
            contextmenu: 'link image imagetools table',
        });
    </script>
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
                                swal("403 Error!", "Unauthorized!", "error");
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
