@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Data Akademik
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
                    <h4 class="card-title">Form Tambah Data Akademik</h4>
                    <form action="/akademik" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="rombel_id">Kelas</label>
                            <select class="form-control" id="rombel_id" name="rombel_id">
                                @foreach($rombels as $rombel)
                                    <option value="{{ $rombel->id }}">{{ $rombel->nama_rombel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="mapel_id">Mata Pelajaran</label>
                            <select class="form-control" id="mapel_id" name="mapel_id">
                                @foreach($mapels as $mapel)
                                    <option value="{{ $mapel->id }}">{{ $mapel->mata_pelajaran }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="tahun_pelajaran">Tahun Pelajaran</label>
                            <input type="text" class="form-control" id="tahun_pelajaran" placeholder="Tahun Pelajaran" name="tahun_pelajaran">
                        </div>

                        <div class="form-group">
                            <label for="santri_id">Nama Santri dan Nilai</label>
                            <div id="santri-container">
                                <!-- Santri akan dimuat di sini via AJAX -->
                            </div>
                        </div>

                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" onclick="window.location='/akademik';">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#rombel_id, #mapel_id, #tahun_pelajaran').on('change', function() {
        let rombel_id = $('#rombel_id').val();
        let mapel_id = $('#mapel_id').val();
        let tahun_pelajaran = $('#tahun_pelajaran').val();

        if (rombel_id && mapel_id && tahun_pelajaran) {
            $.ajax({
                url: '{{ route('getSantris') }}',
                method: 'GET',
                data: {
                    rombel_id: rombel_id,
                    mapel_id: mapel_id,
                    tahun_pelajaran: tahun_pelajaran
                },
                success: function(response) {
                    let html = '';
                    response.forEach(function(santri) {
                        html += `
                            <div class="row mb-2">
                                <div class="col-md-8">
                                    <span>${santri.name}</span>
                                </div>
                                <div class="col-md-4">
                                    <input type="text" class="form-control" name="nilai[]" placeholder="Nilai">
                                    <input type="hidden" name="santri_id[]" value="${santri.id}">
                                </div>
                            </div>
                        `;
                    });
                    $('#santri-container').html(html);
                }
            });
        } else {
            $('#santri-container').html('');
        }
    });
});
</script>
@endsection
@endsection
