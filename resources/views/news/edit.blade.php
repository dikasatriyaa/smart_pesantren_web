@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Edit Berita
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('news.index') }}">Berita</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Berita</li>
            </ul>
        </nav>
    </div>
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
    <div class="row">
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Form Edit Berita</h4>
                    <form action="{{ route('news.update', $news->id) }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Judul</label>
                            <input type="text" class="form-control" id="title" placeholder="Judul" name="title" value="{{ $news->title }}">
                        </div>
                        <div class="form-group">
                            <label for="images">Gambar</label>
                            <input type="file" class="form-control" id="images" name="images">
                        </div>
                        <div class="form-group">
                            <label for="body">Isi Berita</label>
                            <input id="body" type="hidden" name="body" value="{{ $news->body }}">
                            <trix-editor input="body"></trix-editor>
                        </div>
                        <div class="form-group">
                            <label for="author">Penulis</label>
                            <input type="text" class="form-control" id="author" placeholder="Penulis" name="author" value="{{ $news->author }}">
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Update</button>
                        <a href="{{ route('news.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
