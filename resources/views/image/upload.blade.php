@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
<style>
    .modal-body {
        position: relative;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        padding: 0rem;
    }

    .modal-body {
        max-height: 720px;
        overflow-y: auto;
    }

    .cropper-container .cropper-bg {
        height: 700px !important;
    }
</style>
@endsection

@section('content')
<div class="container mt-5">
    <form id="uploadForm" method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
        @csrf
        <!-- Modify the input to accept multiple files -->
        <input type="file" id="image" name="image[]" multiple />

        <div class="modal" id="myModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Crop Image</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <select id="aspectRatio" class="form-control mb-3">
                            <option value="1">Rasio 1:1</option>
                            <option value="1.77777777778">Rasio 16:9</option>
                            <option value="NaN">Sesuaikan</option> <!-- Opsi untuk aspek rasio bebas -->
                        </select>
                        <!-- Placeholder for image preview; you might need a way to preview multiple images -->
                        <div id="imagePreview" class="image-previews"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveImages()">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
    var cropper;
    var modal = $('#myModal');
    var aspectRatioSelect = document.getElementById('aspectRatio');
    var currentFileIndex = 0;
    var files = [];

    // Adjust the event listener to handle multiple file selections
    document.getElementById('image').addEventListener('change', function() {
        files = this.files;
        currentFileIndex = 0;
        if (files.length > 0) {
            readFile(files[currentFileIndex]);
        }
    });

    document.getElementById('aspectRatio').addEventListener('change', function() {
        if (cropper) {
            var value = this.value;
            var newAspectRatio = isNaN(value) ? NaN : parseFloat(value);
            cropper.setAspectRatio(newAspectRatio);
        }
    });

    $('#myModal').on('hidden.bs.modal', function(e) {
        if (cropper) {
            cropper.destroy();
            cropper = null;
            currentFileIndex++;
            if (currentFileIndex < files.length) {
                readFile(files[currentFileIndex]);
            }
        }
    });

    function readFile(file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var imgElement = document.createElement('img');
            imgElement.src = e.target.result;
            var previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = ''; // Clear the preview container
            previewContainer.appendChild(imgElement); // Append the new img element

            if (cropper) {
                cropper.destroy();
            }

            cropper = new Cropper(imgElement, {
                aspectRatio: parseFloat(aspectRatioSelect.value),
                viewMode: 1,
                autoCropArea: 1,
            });

            modal.modal('show');
        };

        reader.readAsDataURL(file);
    }

    window.saveImages = function() {
        var uploadUrl = "{{ url('image') }}";
        if (cropper && files.length > 0) {
            cropper.getCroppedCanvas().toBlob(function(blob) {
                var formData = new FormData();
                formData.append('image[]', blob, 'cropped-' + currentFileIndex + '.jpg');

                $.ajax({
                    url: '{{ route("image.store") }}',
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    },
                    processData: false,
                    contentType: false,
                    data: formData,
                    success: function(response) {
                    console.log(response);
                    alert("Image successfully saved!");
                    if (currentFileIndex < files.length - 1) {
                        $('#myModal').modal('hide');
                        currentFileIndex++;
                        readFile(files[currentFileIndex]); // Process next image
                    } else {
                        $('#myModal').modal('hide');
                        window.location.href = uploadUrl;
                    }
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
    };
});

</script>
@endsection
