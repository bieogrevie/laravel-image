@extends('layouts.main')

@section('style')
<style>
    .table img {
        transition: transform 0.25s ease;
        transform-origin: top left;
    }

    .table img:hover {
        transform: scale(6);
        z-index: 10;
    }
</style>
@endsection
@section('content')
<div class="container mt-5">
    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <h5>Image List</h5>
    <table class="table" width="100%">
        <thead>
            <tr class="btn-secondary">
                <th style="width: 10%">ID</th>
                <th style="width: 30%">Filename</th>
                <th style="width: 50%">Preview</th>
                <th style="width: 20%">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($images as $image)
            <tr>
                <td>{{ $image->id }}</td>
                <td>{{ $image->filename }}</td>
                <td>
                    <img src="{{ asset('storage/' . $image->filename) }}" alt="Preview" style="max-height: 50px; height: auto;">
                </td>
                <td>
                    <form action="{{ route('image.destroy', $image->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this image?');">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div class="d-flex justify-content-center">
        {{ $images->links('pagination::bootstrap-4') }}
    </div>
</div>
@endsection
