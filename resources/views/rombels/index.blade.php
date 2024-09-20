@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Rombel
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
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Daftar Rombel</h4>
                        <a href="/rombel/create" class="btn btn-gradient-success btn-fw">Tambah Data</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Tahun Pelajaran </th>
                                <th> Tingkat Kelas </th>
                                <th> Nama Rombel </th>
                                <th> Wali Kelas </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($rombels as $rombel)
                            <tr>
                                <td>{{ $rombel->tahun_pelajaran }}</td>
                                <td>{{ $rombel->tingkat_kelas }}</td>
                                <td>{{ $rombel->nama_rombel }}</td>
                                <td>{{ $rombel->guru->user->name }}</td>
                                <td>
                                    <a href="/rombel/{{$rombel->id}}/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="/rombel/{{$rombel->id}}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
