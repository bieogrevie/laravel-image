
<!DOCTYPE html>
<html>
<head>
    <title>Image List</title>
    <!-- Sertakan Bootstrap CSS jika diperlukan -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Tambahkan menu navigasi -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/upload') }}">Upload Image</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ url('/images') }}">Image List</a>
            </li>
        </ul>
    </div>
</nav>

@yield('content')


<!-- Sertakan Bootstrap JS dan Popper.js jika diperlukan -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
