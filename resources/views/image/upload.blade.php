<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
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

    <div class="container mt-5">
        <form id="uploadForm" method="POST" action="{{ route('upload.store') }}" enctype="multipart/form-data">
            @csrf
            <!-- Formulir Input File -->
            <input type="file" id="image" name="image" />

            <!-- Tampilan Modal -->
            <div class="modal" id="myModal">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <!-- Tombol Close di Modal -->
                        <div class="modal-header">
                            <h4 class="modal-title">Crop Image</h4>
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>

                        <!-- Isi Modal -->
                        <div class="modal-body">
                            <img id="imagePreview" style="display: none; max-width: 100%;" />
                        </div>

                        <!-- Tombol Simpan dan Close di Modal -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary" onclick="saveImage()">Simpan</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        var cropper;

        document.getElementById('image').addEventListener('change', function() {
            var input = this;
            var preview = document.getElementById('imagePreview');
            var modal = $('#myModal');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    if (cropper) {
                        cropper.destroy();
                    }

                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    cropper = new Cropper(preview, {
                        aspectRatio: NaN,
                        viewMode: 2,
                        autoCropArea: 1,
                    });

                    modal.modal('show');
                };

                reader.readAsDataURL(input.files[0]);
            }
        });

        $('#myModal').on('hidden.bs.modal', function() {
            if (cropper) {
                cropper.destroy();
                cropper = null;
                document.getElementById('imagePreview').style.display = 'none';
            }
        });

        function saveImage() {
            if (cropper && document.getElementById('image').files.length > 0) {
                cropper.getCroppedCanvas().toBlob(function(blob) {
                    var formData = new FormData();
                    formData.append('image', blob, 'cropped.jpg');

                    $.ajax({
                        url: '{{ route("upload.store") }}', // Ensure this is replaced with actual endpoint
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        },
                        processData: false,
                        contentType: false,
                        data: formData,
                        success: function(response) {
                            console.log(response);
                            alert("Gambar berhasil disimpan!");
                            $('#myModal').modal('hide');
                        },
                        error: function(error) {
                            console.error(error);
                            alert("Gagal menyimpan gambar.");
                        }
                    });
                });
            } else {
                alert("Please select and crop an image before saving.");
            }
        }
    </script>


</body>

</html>
