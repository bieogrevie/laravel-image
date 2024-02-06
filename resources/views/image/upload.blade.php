@extends('layouts.main')

@section('style')
<link rel="stylesheet" href="https://unpkg.com/cropperjs/dist/cropper.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://unpkg.com/cropperjs/dist/cropper.min.js"></script>
@endsection

@section('content')
<div class="container mt-5">
    <form id="uploadForm" method="POST" action="{{ route('image.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="file" id="image" name="image" />

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
                        <img id="imagePreview" style="display: none; max-width: 100%;" />
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" onclick="saveImage()">Simpan</button>
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
    var cropper;

        document.getElementById('image').addEventListener('change', function() {
            var input = this;
            var preview = document.getElementById('imagePreview');
            var modal = $('#myModal');
            var aspectRatioSelect = document.getElementById('aspectRatio');

            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';

                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(preview, {
                        aspectRatio: parseFloat(aspectRatioSelect.value),
                        viewMode: 1,
                        autoCropArea: 1,
                    });

                    modal.modal('show');
                };

                reader.readAsDataURL(input.files[0]);
            }
        });

        // Event listener untuk perubahan aspek rasio dari dropdown
        document.getElementById('aspectRatio').addEventListener('change', function() {
            if (cropper) {
                var value = this.value;
                var newAspectRatio = isNaN(value) ? NaN : parseFloat(value);
                cropper.setAspectRatio(newAspectRatio);
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
            var uploadUrl = "{{ url('image') }}";
            if (cropper && document.getElementById('image').files.length > 0) {
                cropper.getCroppedCanvas().toBlob(function(blob) {
                    var formData = new FormData();
                    formData.append('image', blob, 'cropped.jpg');

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
                            alert("Gambar berhasil disimpan!");
                            $('#myModal').modal('hide');
                            window.location.href = uploadUrl;
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
@endsection
