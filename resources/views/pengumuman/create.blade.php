@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Pengumuman
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                </li>
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
                    <h4 class="card-title">Form Tambah Pengumuman</h4>
                    <form action="/pengumuman" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="pengumuman">Pengumuman</label>
                            <input type="text" class="form-control" id="pengumuman" placeholder="Pengumuman" name="pengumuman">
                        </div>
                        <div class="form-group">
                            <label for="editor">Editor</label>
                            <input type="text" class="form-control" id="editor" placeholder="Editor" name="editor">
                        </div>
                        <div class="form-group">
                            <label for="publish">Publish</label>
                            <select class="form-control" id="publish" name="publish">
                                <option value="1">Published</option>
                                <option value="0">Not Published</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" onclick="window.location='{{ route('pengumuman.index') }}';">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
