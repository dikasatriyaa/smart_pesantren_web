@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Edit Data Hafalan
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
                    <h4 class="card-title">Form Edit Data Hafalan</h4>
                    <form action="{{ route('hafalan.update', $hafalan->id) }}" method="POST" class="forms-sample">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="santri_id">Nama Santri</label>
                            <select class="form-control" id="santri_id" name="santri_id" disabled>
                                <option value="{{ $hafalan->santri->id }}">{{ $hafalan->santri->name }}</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="juz">Juz</label>
                            <input type="text" class="form-control" id="juz" placeholder="Juz" name="juz" value="{{ $hafalan->juz }}">
                        </div>
                        <div class="form-group">
                            <label for="progres">Progres</label>
                            <input type="number" class="form-control" id="progres" placeholder="Progres" name="progres" value="{{ $hafalan->progres }}" min="0" max="100">
                        </div>
                        <div class="form-group">
                            <label for="catatan">Catatan</label>
                            <input type="text" class="form-control" id="catatan" placeholder="Catatan" name="catatan" value="{{ $hafalan->catatan }}">
                        </div>
                        <div class="form-group">
                            <label for="guru_id">Nama Ustadz</label>
                            <select class="form-control" id="guru_id" name="guru_id">
                                @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}" {{ $guru->id == $hafalan->guru_id ? 'selected' : '' }}>{{ $guru->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" onclick="window.location='/hafalans';">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
