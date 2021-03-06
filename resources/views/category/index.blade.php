@extends('layouts.app')

@push('top')
<link rel="stylesheet" href="{{ asset('css/datatables.min.css') }}">
@endpush

@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col">
                    <h6 class="h2 text-white d-inline-block mb-0">Kategori</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Data Pekerjaan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kategori</li>
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
        <div class="col-5">
            <form>
                <input type="hidden" value="{{ route('category.store') }}" ref="store_update">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Form Kategori</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input v-model="model.name" type="text" name="name" id="name" class="form-control" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="name">Deskripsi</label>
                            <textarea v-model="model.description" name="description" id="description" cols="30" rows="5"
                                class="form-control">{{ old('description') }}</textarea>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button @click.prevent="submitForm()" type="submit" class="btn btn-primary">@{{ submitText }}</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Data Kategori</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable">
                            <thead class="thead-light">
                                <tr>
                                    <th>#ID</th>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
@endsection

@push('bottom')
<script src="{{ asset('js/form-table.js') }}"></script>
<script src="{{ asset('js/datatables.min.js') }}"></script>

<script>
$(document).ready(function(){
    $('#dataTable').DataTable({
        order: [[ 0, "desc" ]],
        responsive: true,
        processing: true,
        serverSide: true,
        ajax:"{{ route('datatable.category') }}",
        columns: [
            {data: 'id', name: 'id'},
            {data: 'name', name: 'name'},
            {data: 'description', name: 'description'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ],
        language: {
            paginate: {
                next: '<i class="fas fa-angle-right"></i>',
                previous: '<i class="fas fa-angle-left"></i>',
            }
        }
    });
});
</script>
@endpush