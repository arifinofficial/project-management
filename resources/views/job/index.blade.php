@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col col-lg-6 col-7">
                    <h6 class="h2 text-white d-inline-block mb-0">Pekerjaan</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Data Pekerjaan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pekerjaan</li>
                        </ol>
                    </nav>
                </div>
                @can('create job')
                <div class="col-lg-6 col-5 text-right">
                    <a href="{{ route('job.create') }}" class="btn btn-sm btn-neutral">Tambah Pekerjaan</a>
                </div>
                @endcan
            </div>
        </div>
    </div>
</div>
<!-- End Header -->
<!-- Page Content -->
<div class="container-fluid mt--6">
    <div class="row justify-content-center">
        @foreach ($jobs as $key => $job)
            <div class="col-4">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0 text-center">{{ $job->name }}</h3>
                    </div>
                    <div class="card-body text-center">
                        <div class="content">
                            <div class="wrapper-badge mb-4">
                                <span class="badge badge-primary">{{ count($job->departements) }} Departement</span>
                                <span class="badge badge-success">
                                    {{ $job->taskCount() }} Pekerjaan
                                </span>
                            </div>
                            <p class="small"><i class="ni ni-time-alarm d-block mb-1"></i> {{ $job->start }} - {{ $job->end }}</p>  
                            <div class="d-flex align-items-center">
                                <span class="completion mr-2 small">{{ $job->progress }}%</span>
                                <div class="w-100">
                                    <div class="progress m-0" style="width: 100%; height: 3px;">
                                        <div class="progress-bar {{ $job->progress < 50 ? 'bg-warning' : ($job->progress < 80 ? 'bg-primary' : 'bg-success') }}" role="progressbar" aria-valuenow="60" aria-valuemin="0"
                                            aria-valuemax="100" style="width: {{ $job->progress }}%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-md-8">
                                <span class="small">Dibuat oleh </span> <span class="badge badge-warning">{{ Auth::user($job->user_id)->name }}</span>
                            </div>
                            <div class="col-md-4 text-right">
                                <a href="{{ route('job.edit', $job->id) }}" class="btn btn-primary btn-sm">Lihat</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="row justify-content-center">
        {{ $jobs->links() }}
    </div>
</div>
<!-- End Page Content -->
@endsection