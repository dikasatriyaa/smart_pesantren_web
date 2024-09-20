@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Guru
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i
                        class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
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

                        <h4 class="card-title">Daftar Guru</h4>
                        <a href="/guru/create" class="btn btn-gradient-success btn-fw">Tambah Data</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Nama </th>
                                <th> Gelar Depan </th>
                                <th> Gelar Belakang </th>
                                <th> Status Pegawai </th>
                                <th> NPK </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($gurus as $guru)
                            <tr>
                                <td>{{ $guru->user->name }}</td>
                                <td>{{ $guru->gelar_depan }}</td>
                                <td>{{ $guru->gelar_belakang }}</td>
                                <td>{{ $guru->status_pegawai }}</td>
                                <td>{{ $guru->npk }}</td>
                                <td>
                                    {{-- <a href="/guru/{{ $guru->id }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="/guru/{{ $guru->id }}/edit" class="btn btn-primary btn-sm">Edit</a> --}}
                                    <form action="/guru/{{ $guru->id }}" method="POST" style="display: inline-block;">
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
