@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Edit Data Kesehatan
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
                    <h4 class="card-title">Form Edit Data Kesehatan</h4>
                    <form action="{{ route('kesehatan.update', $kesehatan->id) }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="santri_id">Nama Santri</label>
                            <select class="form-control" id="santri_id" name="santri_id">
                                @foreach($santris as $santri)
                                <option value="{{ $santri->id }}" {{ $santri->id == $kesehatan->santri_id ? 'selected' : '' }}>{{ $santri->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="keluhan">Keluhan</label>
                            <input type="text" class="form-control" id="keluhan" placeholder="Keluhan" name="keluhan" value="{{ $kesehatan->keluhan }}">
                        </div>
                        <div class="form-group">
                            <label for="diagnosa">Diagnosa</label>
                            <input type="text" class="form-control" id="diagnosa" placeholder="Diagnosa" name="diagnosa" value="{{ $kesehatan->diagnosa }}">
                        </div>
                        <div class="form-group">
                            <label for="dokter">Dokter</label>
                            <input type="text" class="form-control" id="dokter" placeholder="Dokter" name="dokter" value="{{ $kesehatan->dokter }}">
                        </div>
                        <div class="form-group">
                            <label for="obat_dikonsumsi">Obat yang Dikonsumsi</label>
                            <input type="text" class="form-control" id="obat_dikonsumsi" placeholder="Obat yang Dikonsumsi" name="obat_dikonsumsi" value="{{ $kesehatan->obat_dikonsumsi }}">
                        </div>
                        <div class="form-group">
                            <label for="obat_dokter">Obat dari Dokter</label>
                            <input type="text" class="form-control" id="obat_dokter" placeholder="Obat dari Dokter" name="obat_dokter" value="{{ $kesehatan->obat_dokter }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_masuk">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="{{ $kesehatan->tanggal_masuk }}">
                        </div>
                        <div class="form-group">
                            <label for="tanggal_keluar">Tanggal Keluar</label>
                            <input type="date" class="form-control" id="tanggal_keluar" name="tanggal_keluar" value="{{ $kesehatan->tanggal_keluar }}">
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <a href="{{ route('kesehatan.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
