<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{env('APP_NAME')}}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/daterangepicker/daterangepicker.css')}}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/assets/plugins/summernote/summernote-bs4.min.css')}}">

    <link rel="stylesheet" href="{{asset('/assets/plugins/toastr/toastr.min.css')}}">
</head>

<body class="hold-transition sidebar-mini layout-fixed"> 
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{asset('/assets/dist/img/AdminLTELogo.png')}}"
                alt="AdminLTELogo" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{URL::to('/')}}" class="brand-link">
                <img src="{{asset('/assets/dist/img/AdminLTELogo.png')}}" alt="SOFTWARE"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">{{env('APP_NAME')}}</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="{{asset('/assets/dist/img/user2-160x160.jpg')}}"
                            class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="{{URL::to('/')}}" class="d-block">{{ auth()->user()->name ?? null }}</a>
                    </div>
                </div>
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                            aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ url('/') }}" class="nav-link {{ request()->is('/') ? 'active' : '' }} {{ request()->is('/') ? 'dashboard' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/students/create')}}" 
                            class="nav-link {{ request()->is('students/create') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Student Create</p>
                            </a>
                        </li>

                        <li class="nav-item ">
                            <a href="{{ URL::to('/students') }}" 
                              class="nav-link {{ request()->is('students') || request()->is('students/*/edit') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Students List</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{URL::to('students-registration')}}" class="nav-link {{ request()->is('students-registration') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Registration</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{URL::to('class-list')}}" class="nav-link 
                            {{ request()->is('class-list*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Classes</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ URL::to('/logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Logout</p>
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="content-wrapper">
            @yield('content')
        </div>

        <aside class="control-sidebar control-sidebar-dark">
        </aside>
    </div>


    <script src="{{ asset('/assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <script src="{{ asset('/assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/chart.js/Chart.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/sparklines/sparkline.js')}}"></script>
    <script src="{{ asset('/assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
    <script src="{{ asset('/assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
    
    <script src="{{ asset('/assets/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}">
    </script>
    <script src="{{asset('/assets/plugins/summernote/summernote-bs4.min.js')}}"></script>
    <script src="{{asset('/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
    <script src="{{asset('/assets/dist/js/adminlte.js')}}"></script>
    <script src="{{asset('/assets/dist/js/demo.js')}}"></script>
    <script src="{{asset('/assets/dist/js/pages/dashboard.js')}}"></script>
    <script src="{{asset('/assets/plugins/toastr/toastr.min.js')}}"></script>

    <!-- Datatable -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#form').on('submit', function(event) {
                event.preventDefault();

                // Create a new FormData object to handle the form, including file uploads
                const formData = new FormData(this);
                const url = $(this).attr('action');
                const method = 'POST'; // Always POST when using _method spoofing in Laravel
                const csrfToken = $('meta[name="csrf-token"]').attr('content');

                $.ajax({
                    url: url,
                    type: method, // This will still be POST for Laravel but include _method PUT
                    data: formData,
                    contentType: false, // Important for file uploads
                    processData: false, // Important for file uploads
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        toastr.success(response.message);
                    },
                    error: function(xhr) {
                        if (xhr.status === 422) {
                            const errors = xhr.responseJSON.errors;
                            let errorMessage = 'Validation error:\n';
                            for (const key in errors) {
                                if (errors.hasOwnProperty(key)) {
                                    errorMessage += `${key}: ${errors[key].join(', ')}\n`;
                                }
                            }
                            toastr.error(errorMessage);
                        } else {
                            console.error('Error updating student:', xhr.responseText);
                            toastr.error('Please try again.');
                        }
                    }
                });
            });
        });
    </script>


    @if(Session::get('success'))
    <script> toastr.success("{{Session::get('success')}}");</script>
    @endif

    @if(Session::get('error'))
        <script> toastr.error("{{Session::get('error')}}");</script>
    @endif

    @if(Session::get('warning'))
        <script> toastr.warning("{{Session::get('warning')}}");</script>
    @endif

    @yield('script')

</body>

</html>