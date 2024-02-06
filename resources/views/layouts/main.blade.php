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

        /* Custom styles for the modal */
        .modal-dialog {
            width: 800px;
            /* Fixed width */
            height: 600px;
            /* Fixed height */
            display: flex;
            flex-direction: column;
            /* Ensures the header, body, and footer are stacked */
        }

        .modal-content {
            height: 100%;
            display: flex;
            flex-direction: column;
            /* Ensures the header, body, and footer are stacked */
        }

        .modal-body {
            overflow-y: auto;
            /* Enables scrolling within the modal body if content overflows */
            flex-grow: 1;
            /* Allows the body to expand to fill available space */
        }
    </style>
</head>

<body>
    <div class="container mt-3">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('image') ? 'active' : '' }}" href="{{ url('/image') }}">LIST</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('image/create') ? 'active' : '' }}" href="{{ url('/image/create') }}">UPLOAD IMAGE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('image/create_multiple') ? 'active' : '' }}" href="{{ url('/image/create_multiple') }}">UPLOAD IMAGE MULTIPLE</a>
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
