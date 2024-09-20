@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Pelanggaran
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
                    <h4 class="card-title">Form Tambah Pelanggaran</h4>
                    <form action="/pelanggaran" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="santri_id">Nama Santri</label>
                            <select class="form-control" id="santri_id" name="santri_id">
                                @foreach($santris as $santri)
                                <option value="{{ $santri->id }}">{{ $santri->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="pelanggaran">Pelanggaran</label>
                            <input type="text" class="form-control" id="pelanggaran" placeholder="Pelanggaran" name="pelanggaran">
                        </div>
                        <div class="form-group">
                            <label for="tindakan">Tindakan</label>
                            <input type="text" class="form-control" id="tindakan" placeholder="Tindakan" name="tindakan">
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" placeholder="Tanggal" name="tanggal">
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" onclick="window.location='{{ route('pelanggaran.index') }}';">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
