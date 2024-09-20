@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Santri
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
                        <h4 class="card-title">Data Seluruh Santri</h4>
                        @can('admin')
                            
                        <div class="ml-auto">
                            <a href="{{ route('santri.create') }}" class="btn btn-gradient-success btn-fw">Tambah Data</a>
                            <a href="#" class="btn btn-gradient-info btn-fw" data-toggle="modal" data-target="#uploadModal">Upload Data via Excel</a>
                        </div>
                        @endcan
                    </div>
                    
                    <table class="table table-striped" id="myTable">
                        <thead>
                            <tr>
                                <th> Nama </th>
                                <th> NISN </th>
                                <th> No. KK </th>
                                <th> Tanggal Lahir </th>
                                <th> Jenis Kelamin </th>
                                @can('admin')
                                    
                                <th> Aksi </th>
                                @endcan
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($santris as $santri)
                            <tr>
                                <td>{{ $santri->name }}</td>
                                <td>{{ $santri->nisn }}</td>
                                <td>{{ $santri->no_kk }}</td>
                                <td>{{ $santri->tanggal_lahir }}</td>
                                <td>{{ $santri->jenis_kelamin }}</td>
                                @can('admin')
                                        
                                <td>
                                    
                                    <a href="{{ route('santri.edit', $santri->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="{{ route('santri.destroy', $santri->id) }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </td>
                                    @endcan
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Data Santri</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="{{ route('santri.upload.post') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">Pilih File Excel</label>
                        <input type="file" name="excel_file" class="form-control" required>
                    </div>
                    <a href="/file/download" class="">Unduh Template Excel</a>
                    <button type="submit" class="btn btn-gradient-primary me-2">Upload</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                </form>
                <div id="uploadProgress" class="mt-3" style="display:none;">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 0%;" id="progressBar">0%</div>
                    </div>
                    <p id="uploadStatus" class="mt-2"></p>
                </div>
                <div id="uploadMessages" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>
@endsection
