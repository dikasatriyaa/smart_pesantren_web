// resources/views/mapel/edit.blade.php

@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Edit Mata Pelajaran
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
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Edit Mata Pelajaran</h4>
                    <form action="{{ url('/mapel/'.$mapel->id) }}" method="POST">
                       
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="guru_id">Guru Pengajar</label>
                            <select class="form-control" id="guru_id" name="guru_id">
                                @foreach($gurus as $guru)
                                    <option value="{{ $guru->id }}" {{ $guru->id == $mapel->guru_id ? 'selected' : '' }}>
                                        {{ $guru->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="rombel_id">Rombel</label>
                            <select class="form-control" id="rombel_id" name="rombel_id">
                                @foreach($rombels as $rombel)
                                    <option value="{{ $rombel->id }}" {{ $rombel->id == $mapel->rombel_id ? 'selected' : '' }}>
                                        {{ $rombel->nama_rombel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="mata_pelajaran">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mata_pelajaran" name="mata_pelajaran" value="{{ $mapel->mata_pelajaran }}">
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Simpan</button>
                        <a href="{{ url('/mapel') }}" class="btn btn-light">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
