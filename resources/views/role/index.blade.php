@extends('layouts.app')

@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col">
                    <h6 class="h2 text-white d-inline-block mb-0">Role</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Konfigurasi</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Role</li>
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
                    <h3 class="mb-0">Pengaturan Role/Akses</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('role.index') }}" method="GET">
                        <div class="input-group mb-3">
                            <select class="form-control" name="role">
                                @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ request()->get('role') == $role ? 'selected':'' }}>
                                    {{ ucwords($role) }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit" id="check-access">Cek Akses</button>
                            </div>
                        </div>
                    </form>
                    @if (!empty($permissions))
                    <p class="text-primary font-weight-bold mb-1">List Akses</p>
                    <hr class="m-0 mb-3">
                    <form action="{{ route('role.update', request()->get('role')) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @foreach ($permissions as $key => $permission)
                        <div class="form-check mb-1">
                            <input class="form-check-input" name="permissions[]" type="checkbox" value="{{ $permission }}" {{ in_array($permission, $hasPermission) ? 'checked' : '' }}>
                            <label class="form-check-label" for="">
                                {{ ucwords($permission) }}
                            </label>
                        </div>
                        @endforeach
                        <button class="btn btn-warning mt-4">Set Akses</button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
@endsection