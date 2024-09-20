@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Data Kehadiran
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
                    <h4 class="card-title">Form Tambah Data Kehadiran</h4>
                    <form action="{{ route('kehadiran.store') }}" method="POST" class="forms-sample" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="kelas">Kelas</label>
                            <select class="form-control" id="kelas" name="kelas">
                                <option value="">Pilih Kelas</option>
                                @foreach($rombels as $rombel)
                                    <option value="{{ $rombel->id }}">{{ $rombel->nama_rombel }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div id="santri-select">
                            {{-- Santri options will be loaded dynamically --}}
                        </div>
                        <div class="form-group">
                            <label for="tanggal">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ now()->format('Y-m-d') }}">
                        </div>
                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button class="btn btn-light">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#kelas').change(function() {
            var rombelId = $(this).val();
            var tanggal = $('#tanggal').val();
            $.ajax({
                url: '/santris-by-rombel/' + rombelId + '?tanggal=' + tanggal,
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    var santris = data.santris;
                    var santriOptions = '';
                    santris.forEach(function(santri) {
                        santriOptions += '<div class="form-group row">';
                        santriOptions += '<div class="col-md-4 d-flex align-items-center">';
                        santriOptions += '<label for="santri_' + santri.id + '">' + santri.name + '</label>';
                        santriOptions += '<input type="hidden" name="santris[' + santri.id + '][santri_id]" value="' + santri.id + '">';
                        santriOptions += '</div>';
                        santriOptions += '<div class="col-md-8 d-flex justify-content-end align-items-center">';
                        santriOptions += '<div class="form-check form-check-inline" style="margin-right: 20px">';
                        santriOptions += '<input class="form-check-input" type="radio" name="santris[' + santri.id + '][status]" id="hadir_' + santri.id + '" value="Hadir" required>';
                        santriOptions += '<label class="form-check-label" for="hadir_' + santri.id + '" style="margin-left: 5px; padding-right: 20px">Hadir</label>';
                        santriOptions += '</div>';
                        santriOptions += '<div class="form-check form-check-inline" style="margin-right: 20px">';
                        santriOptions += '<input class="form-check-input" type="radio" name="santris[' + santri.id + '][status]" id="sakit_' + santri.id + '" value="Sakit">';
                        santriOptions += '<label class="form-check-label" for="sakit_' + santri.id + '" style="margin-left: 5px; padding-right: 20px">Sakit</label>';
                        santriOptions += '</div>';
                        santriOptions += '<div class="form-check form-check-inline" style="margin-right: 20px">';
                        santriOptions += '<input class="form-check-input" type="radio" name="santris[' + santri.id + '][status]" id="izin_' + santri.id + '" value="Izin">';
                        santriOptions += '<label class="form-check-label" for="izin_' + santri.id + '" style="margin-left: 5px; padding-right: 20px">Izin</label>';
                        santriOptions += '</div>';
                        santriOptions += '<div class="form-check form-check-inline" style="margin-right: 20px">';
                        santriOptions += '<input class="form-check-input" type="radio" name="santris[' + santri.id + '][status]" id="alpa_' + santri.id + '" value="Alpa">';
                        santriOptions += '<label class="form-check-label" for="alpa_' + santri.id + '" style="margin-left: 5px; padding-right: 20px">Alpa</label>';
                        santriOptions += '</div>';
                        santriOptions += '<input type="hidden" name="santris[' + santri.id + '][masuk]" class="waktu-masuk" id="masuk_' + santri.id + '">';
                        santriOptions += '</div>';
                        santriOptions += '</div>';
                    });
                    $('#santri-select').html(santriOptions);
                    updateWaktuMasuk();
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching santris:', error);
                }
            });
        });

        function updateWaktuMasuk() {
            $('input[type=radio][name^=santris]').change(function() {
                var santriId = $(this).attr('name').match(/\d+/)[0];
                var status = $(this).val();
                var waktuMasuk = (status === 'Hadir') ? '{{ now()->format('H:i:s') }}' : null;
                $('#masuk_' + santriId).val(waktuMasuk);
            });
        }
    });
</script>
@endsection
