@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Kesehatan
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
                    <h4 class="card-title">Kesehatan Table</h4>
                    </p>
                    <a href="/kesehatan/create" class="btn btn-gradient-success btn-fw">Tambah Data</a>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th> Santri </th>
                                <th> Keluhan </th>
                                <th> Diagnosa </th>
                                <th> Dokter </th>
                                <th> Tanggal Masuk </th>
                                <th> Tanggal Keluar </th>
                                <th> Aksi </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($kesehatans as $kesehatan)
                            <tr>
                                <td>{{ $kesehatan->santri->name }}</td>
                                <td>{{ $kesehatan->keluhan }}</td>
                                <td>{{ $kesehatan->diagnosa }}</td>
                                <td>{{ $kesehatan->dokter }}</td>
                                <td>{{ $kesehatan->tanggal_masuk }}</td>
                                <td>{{ $kesehatan->tanggal_keluar }}</td>
                                <td>
                                    <a href="/kesehatan/{{ $kesehatan->id }}" class="btn btn-info btn-sm">Detail</a>
                                    <a href="/kesehatan/{{ $kesehatan->id }}/edit" class="btn btn-primary btn-sm">Edit</a>
                                    <form action="/kesehatan/{{ $kesehatan->id }}" method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                    @if(is_null($kesehatan->tanggal_keluar))
                                    <button type="button" class="btn btn-success btn-sm sembuh-btn" data-id="{{ $kesehatan->id }}">Sembuh</button>
                                    @endif
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

@section('scripts')
<script>
    $(document).ready(function() {
        $('.sembuh-btn').click(function() {
            var id = $(this).data('id');
            $.ajax({
                url: '/kesehatan/sembuh/' + id,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    location.reload();
                },
                error: function(xhr) {
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>
@endsection
