@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Pengumuman
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
                    <h4 class="card-title">Daftar Pengumuman</h4>
                    <a href="/pengumuman/create" class="btn btn-gradient-success btn-fw">Tambah Pengumuman</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Pengumuman </th>
                                <th> Editor </th>
                                <th> Publish </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pengumumen as $pengumuman)
                            <tr>
                                <td>{{ $pengumuman->pengumuman }}</td>
                                <td>{{ $pengumuman->editor }}</td>
                                <td>{{ $pengumuman->publish ? 'Published' : 'Not Published' }}</td>
                                <td>
                                    <a href="/pengumuman/{{ $pengumuman->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="/pengumuman/{{ $pengumuman->id }}" method="POST" style="display: inline-block;">
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
