<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />

    <title>{{ isset($headerTitle) ? $headerTitle . '-' : '' }}Admin Dashboard</title>

    {{-- <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" /> --}}
    <link href="{{ asset('style/main.css') }}" rel="stylesheet" />

    <script src="https://use.fontawesome.com/4acdae30cc.js"></script>
</head>

<body>
    <div class="page-dashboard">
        <div class="d-flex" id="wrapper" data-aos="fade-right">
            <!-- Sidebar -->
            <div class="border-right" id="sidebar-wrapper">
                <div class="sidebar-heading text-center">
                    <img src="/images/admin.png" width="100px" height="100px" alt="" class="my-4" />
                </div>
                <div class="list-group list-group-flush">
                    <a href="{{ route('admin-dashboard') }}"

                        class="list-group-item list-group-item-action">
                        Dashboard
                    </a>
                    <a href="{{ route('admin-category.index') }}" 
                        class="list-group-item list-group-item-action {{ (request()->is('admin/category*')) ? 'active' : '' }}">
                        Categories
                    </a>
                    <a href="{{ route('admin-product.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/product*')) ? 'active' : '' }}">
                        Products
                    </a>
                    <a href="{{ route('admin-transaction.index') }}" class="list-group-item list-group-item-action">
                        Transactions
                    </a>
                    <a href="{{ route('admin-user.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/user*')) ? 'active' : '' }}">
                        Users
                    </a>
                    <a href="{{ route('admin-promocode.index') }}" class="list-group-item list-group-item-action {{ (request()->is('admin/promotion-code*')) ? 'active' : '' }}">
                        Promotion Codes
                    </a>
                    <a href="{{ route('logout.admin') }}" class="list-group-item list-group-item-action">
                        Sign Out
                    </a>
                </div>
            </div>
            <!-- /#sidebar-wrapper -->

            <!-- Page Content -->
            <div id="page-content-wrapper">
                <nav class="navbar navbar-store navbar-expand-lg navbar-light fixed-top" data-aos="fade-down">
                    <button class="btn btn-secondary d-md-none mr-auto mr-2" id="menu-toggle">
                        &laquo; Menu
                    </button>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto d-none d-lg-flex">
                            <li class="nav-item dropdown">
                                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ $customer->profile->file->fileUrl ?? asset('images/admin.png') }}" alt=""
                                        class="rounded-circle mr-2 profile-picture" />
                                    Hi, {{ Auth::user()->name }}
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('admin-profile', Auth::user()) }}">Profile</a>
                                    <a class="dropdown-item" href="{{ route('admin-profile.edit', Auth::user()) }}">Update Profile</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout.admin') }}">Logout</a>
                                </div>
                            </li>
                        </ul>
                        <!-- Mobile Menu -->
                        <ul class="navbar-nav d-block d-lg-none mt-3">
                            <li class="nav-item">
                                <a class="nav-link" href="#">
                                    Hi, {{ Auth::user()->name }}
                                </a>
                            </li>
                        </ul>
                    </div>
                </nav>

                {{-- Content --}}
                @yield('content')
            </div>
            <!-- /#page-content-wrapper -->
        </div>
    </div>
    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('/vendor/jquery/jquery.slim.min.js') }}"></script>
    <script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    {{-- <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script> --}}
    {{-- <script>
        AOS.init();
    </script> --}}
    <!-- Menu Toggle Script -->
    <script>
        $("#menu-toggle").click(function (e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
      });
    </script>
    @yield('javascript')
</body>

</html>