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
            <form :action="formUrl" method="POST">
                <input v-if="fetchStatus == true" type="hidden" name="_method" value="PATCH">
                @csrf
                <div class="card">
                    <div class="card-header">
                        <h3 class="mb-0">Form Kategori</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Kategori</label>
                            <input v-model="category.name" type="text" name="name" id="name" class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name') }}">
                            @if ($errors->has('name'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="name">Deskripsi</label>
                            <textarea v-model="category.description" name="description" id="description" cols="30" rows="5"
                                class="form-control">{{ old('description') }}</textarea>
                            @if ($errors->has('description'))
                            <span class="invalid-feedback">
                                <strong>{{ $errors->first('description') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button type="submit" class="btn btn-primary">@{{ submitText }}</button>
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
                        <table class="table" id="table">
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
<script src="{{ asset('js/datatables.min.js') }}"></script>

<script>
$(document).ready(function(){
    $('#table').DataTable({
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

    $('.container-fluid').on('click', '.editAction', function(){
        vm.$data.action.editUrl = $(this).data('action');
    });

    $('.container-fluid').on('click', '.deleteAction', function(){
        vm.$data.action.deleteUrl = $(this).data('action');
    });
});
</script>

<script>
var vm = new Vue({
    el: '#app',
    data: {
        formAction: '',
        action: {
            editUrl: '',
            deleteUrl: '',
        },
        fetchStatus: false,
        category: {},
    },
    watch: {
        'action.editUrl': function(){
            this.editMethod();
        },
        'action.deleteUrl': function(){
            this.deleteMethod();
        }
    },
    computed:{
        formUrl()
        {
            return this.fetchStatus == true ? `category/${this.category.id}` : "{{ route('category.store') }}";
        },
        submitText()
        {
            return this.fetchStatus == true ? 'Ubah' : 'Tambah';
        }
    },
    methods: {
        editMethod() {
            axios.get(this.action.editUrl)
            .then((response) => {
                this.category = response.data;
                this.fetchStatus = true;
            })
        },
        deleteMethod() {
            axios.delete(this.action.deleteUrl)
            .then((response) => {
                location.reload();
            })
        }
    }
});
</script>
@endpush