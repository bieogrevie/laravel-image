@extends('main')

@section('content')

<div class="container mt-5">
    <h2>Image List</h2>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Filename</th>
                <th>Preview</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($images as $image)
                <tr>
                    <td>{{ $image->id }}</td>
                    <td>{{ $image->filename }}</td>
                    <td>
                        {{-- Sesuaikan path sesuai dengan lokasi penyimpanan gambar --}}
                        <img src="{{ asset('storage/' . $image->filename) }}" alt="Preview" style="max-width: 200px; height: auto;">
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
