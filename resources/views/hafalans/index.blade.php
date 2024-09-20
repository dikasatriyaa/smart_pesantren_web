@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Hafalan
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
                    <h4 class="card-title">Hafalan Table</h4>
                    </p>
                    <a href="/hafalan/create" class="btn btn-gradient-success btn-fw">Tambah Data</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Santri </th>
                                <th> Penguji </th>
                                <th> Juz </th>
                                <th> Progres </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($hafalans as $hafalan)
                            <tr>
                                <td>{{ $hafalan->santri->name }}</td>
                                <td>{{ $hafalan->guru->user->name }}</td>
                                <td>{{ $hafalan->juz }}</td>
                                <td>{{ $hafalan->progres }}</td>
                                <td>
                                    {{-- <a href="/hafalan/{{ $hafalan->id }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="/hafalan/{{ $hafalan->id }}/edit" class="btn btn-primary btn-sm">Edit</a> --}}
                                    <form action="/hafalan/{{ $hafalan->id }}" method="POST"
                                        style="display: inline-block;">
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