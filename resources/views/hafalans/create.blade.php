@extends('layouts.main')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-home"></i>
            </span> Tambah Data Hafalan
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
                    <h4 class="card-title">Form Tambah Data Hafalan</h4>
                    <form action="{{ route('hafalan.store') }}" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                            <label for="rombel_id">Pilih Kelas</label>
                            <select class="form-control" id="rombel_id" name="rombel_id">
                                <option value="">-- Pilih Kelas --</option>
                                @foreach($rombel as $kelas)
                                <option value="{{ $kelas->id }}">{{ $kelas->nama_rombel }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group" id="santri-container">
                            <!-- Data santri akan dimuat di sini -->
                        </div>

                        <div class="form-group">
                            <label for="guru_id">Nama Ustadz</label>
                            <select class="form-control" id="guru_id" name="guru_id">
                                @foreach($gurus as $guru)
                                <option value="{{ $guru->id }}">{{ $guru->user->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                        <button type="button" class="btn btn-light" onclick="window.location='{{ route('hafalan.index') }}';">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#rombel_id').change(function() {
            let rombelId = $(this).val();
            if (rombelId) {
                $.ajax({
                    url: '{{ route("hafalan.getSantrisByRombel") }}',
                    type: 'GET',
                    data: { rombel_id: rombelId },
                    success: function(response) {
                        let santriHtml = '';
                        $.each(response, function(index, santri) {
                            santriHtml += `
                                <div class="d-flex justify-content-between mb-2">
                                    <div class="col-6">
                                        <span>${santri.name}</span>
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="juz[]" placeholder="Juz">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="progres[]" placeholder="Progres">
                                    </div>
                                    <div class="col-2">
                                        <input type="text" class="form-control" name="catatan[]" placeholder="Catatan">
                                        <input type="hidden" name="santri_id[]" value="${santri.id}">
                                    </div>
                                </div>
                            `;
                        });
                        $('#santri-container').html(santriHtml);
                    }
                });
            } else {
                $('#santri-container').empty();
            }
        });
    });
</script>
@endsection
