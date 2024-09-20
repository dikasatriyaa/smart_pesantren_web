@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-book-open"></i>
            </span> Edit Data Kitab
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
                    <h4 class="card-title">Form Edit Data Kitab</h4>
                    <form action="{{ route('kitab.update', $kitab->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="rombel_id">Rombel</label>
                            <select class="form-control" id="rombel_id" name="rombel_id">
                                @foreach($rombels as $rombel)
                                    <option value="{{ $rombel->id }}" {{ $rombel->id == $kitab->rombel_id ? 'selected' : '' }}>
                                        {{ $rombel->nama_rombel }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="nama_kitab">Nama Kitab</label>
                            <input type="text" class="form-control" id="nama_kitab" placeholder="Nama Kitab" name="nama_kitab" value="{{ $kitab->nama_kitab }}">
                        </div>
                        <div class="form-group">
                            <label for="mata_pelajaran">Mata Pelajaran</label>
                            <input type="text" class="form-control" id="mata_pelajaran" placeholder="Mata Pelajaran" name="mata_pelajaran" value="{{ $kitab->mata_pelajaran }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" rows="4" placeholder="Keterangan" name="keterangan">{{ $kitab->keterangan }}</textarea>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary mr-2">Submit</button>
                        <a href="{{ route('kitab.index') }}" class="btn btn-light">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
