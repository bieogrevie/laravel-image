<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

    @yield('style')

    <style>
        .table img {
            transition: transform 0.25s ease;
            transform-origin: top left;
        }

        .table img:hover {
            transform: scale(6);
            z-index: 10;
        }

        .modal-body {
            position: relative;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 0rem;
        }
    </style>
</head>

<body>
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('image') ? 'active' : '' }}" href="{{ url('/image') }}">LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('image/create') ? 'active' : '' }}" href="{{ url('/image/create') }}">UPLOAD IMAGE</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>

    @yield('content')

    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

    @yield('script')

</body>
</html>
