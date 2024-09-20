@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Data Guru
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
                    <h4 class="card-title">Form Tambah Data Guru</h4>
                    <form action="/guru" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="user_id">Nama User</label>
                            <select class="form-control" id="user_id" name="user_id">
                                <option value="">Pilih User</option>
                                @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="gelar_depan">Gelar Depan</label>
                            <input type="text" class="form-control" id="gelar_depan" placeholder="Gelar Depan" name="gelar_depan">
                        </div>
                        <div class="form-group">
                            <label for="gelar_belakang">Gelar Belakang</label>
                            <input type="text" class="form-control" id="gelar_belakang" placeholder="Gelar Belakang" name="gelar_belakang">
                        </div>
                        <div class="form-group">
                            <label for="status_pegawai">Status Pegawai</label>
                            <input type="text" class="form-control" id="status_pegawai" placeholder="Status Pegawai" name="status_pegawai">
                        </div>
                        <div class="form-group">
                            <label for="npk">NPK</label>
                            <input type="text" class="form-control" id="npk" placeholder="NPK" name="npk">
                        </div>
                        <div class="form-group">
                            <label for="tmt_pegawai">TMT Pegawai</label>
                            <input type="text" class="form-control" id="tmt_pegawai" placeholder="TMT Pegawai" name="tmt_pegawai">
                        </div>
                        <div class="form-group">
                            <label for="npwp">NPWP</label>
                            <input type="text" class="form-control" id="npwp" placeholder="NPWP" name="npwp">
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
