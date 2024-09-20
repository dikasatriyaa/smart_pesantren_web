@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Data Rombel
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
                    <h4 class="card-title">Form Tambah Data Rombel</h4>
                    <form action="/rombel" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="tahun_pelajaran">Tahun Pelajaran</label>
                            <input type="text" class="form-control" id="tahun_pelajaran" placeholder="Tahun Pelajaran" name="tahun_pelajaran">
                        </div>
                        <div class="form-group">
                            <label for="tingkat_kelas">Tingkat Kelas</label>
                            <input type="text" class="form-control" id="tingkat_kelas" placeholder="Tingkat Kelas" name="tingkat_kelas">
                        </div>
                        <div class="form-group">
                            <label for="nama_rombel">Nama Rombel</label>
                            <input type="text" class="form-control" id="nama_rombel" placeholder="Nama Rombel" name="nama_rombel">
                        </div>
                        <div class="form-group">
                            <label for="guru_id">Wali Kelas</label>
                            <select class="form-control" id="guru_id" name="guru_id" required>
                                <option value="">Pilih Guru</option>
                                @foreach($gurus as $guru)
                                {{$guru}}
                                    <option value="{{ $guru->id }}">{{ $guru->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
