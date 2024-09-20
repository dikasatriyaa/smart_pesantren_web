@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Data Akademik
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
                        <h4 class="card-title">Data Akademik</h4>
                        <a href="/akademik/create" class="btn btn-gradient-success btn-fw">Tambah Data</a>
                    </div>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Santri </th>
                                <th> Mata Pelajaran </th>
                                <th> Tahun Pelajaran </th>
                                <th> Nilai </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($akademiks as $akademik)
                            <tr>
                                <td>{{ $akademik->santri->name }}</td>
                                <td>{{ $akademik->mapel->mata_pelajaran }}</td>
                                <td>{{ $akademik->tahun_pelajaran }}</td>
                                <td>{{ $akademik->nilai }}</td>
                                <td>
                                    {{-- <a href="/akademik/{{ $akademik->id }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="/akademik/{{ $akademik->id }}/edit" class="btn btn-primary btn-sm">Edit</a> --}}
                                    <form action="/akademik/{{ $akademik->id }}" method="POST"
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
