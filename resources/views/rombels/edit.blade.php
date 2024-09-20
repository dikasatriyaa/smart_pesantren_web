@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Edit Data Rombel
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
                    <h4 class="card-title">Form Edit Data Rombel</h4>
                    <form action="/rombel/{{$rombel->id}}" method="POST" class="forms-sample">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="tahun_pelajaran">Tahun Pelajaran</label>
                            <input type="text" class="form-control" id="tahun_pelajaran" placeholder="Tahun Pelajaran" name="tahun_pelajaran" value="{{ $rombel->tahun_pelajaran }}" required>
                        </div>
                        <div class="form-group">
                            <label for="tingkat_kelas">Tingkat Kelas</label>
                            <input type="text" class="form-control" id="tingkat_kelas" placeholder="Tingkat Kelas" name="tingkat_kelas" value="{{ $rombel->tingkat_kelas }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama_rombel">Nama Rombel</label>
                            <input type="text" class="form-control" id="nama_rombel" placeholder="Nama Rombel" name="nama_rombel" value="{{ $rombel->nama_rombel }}" required>
                        </div>
                        <div class="form-group">
                            <label for="guru_id">Wali Kelas</label>
                            <select class="form-control" id="guru_id" name="guru_id" required>
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ $rombel->guru_id == $guru->id ? 'selected' : '' }}>{{ $guru->user->name }}</option>
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
