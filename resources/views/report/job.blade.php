@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col">
                    <h6 class="h2 text-white d-inline-block mb-0">Laporan</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Laporan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pekerjaan</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Header -->
<!-- Page Content -->
<div class="container-fluid mt--6">
    <div class="row">
        <div class="col-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Laporan Pekerjaan</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('report.job.pdf') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="">Data Pekerjaan</label>
                            <select name="job" id="select2" class="form-control select2">
                                @foreach ($jobs as $job)
                                    <option value="{{ $job->id }}">{{ $job->name }} {{ $job->deleted_at != null ? '- ARSIP' : '' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group text-right">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i> Cetak</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
@endsection

@push('top')
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endpush

@push('bottom')
<script src="{{ asset('js/select2.min.js') }}"></script>

<script>
    $(document).ready(function(){
        $('#select2').select2();
    });
</script>
@endpush