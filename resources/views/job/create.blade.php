@extends('layouts.app')

@push('top')
<link rel="stylesheet" href="{{ asset('css/bootstrap-datetimepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
@endpush

@section('content')
<!-- Header -->
<div class="header bg-primary pb-6">
    <div class="container-fluid">
        <div class="header-body">
            <div class="row align-items-center py-4">
                <div class="col">
                    <h6 class="h2 text-white d-inline-block mb-0">Pekerjaan Baru</h6>
                    <nav aria-label="breadcrumb" class="d-none d-md-inline-block ml-md-4">
                        <ol class="breadcrumb breadcrumb-links breadcrumb-dark">
                            <li class="breadcrumb-item"><a href="#"><i class="fas fa-home"></i></a></li>
                            <li class="breadcrumb-item"><a href="#">Data Pekerjaan</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Pekerjaan Baru</li>
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
    <form action="">
        <div class="row justify-content-center">
            <div class=" col ">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">Pekerjaan Baru</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-row">
                            <div class="col form-group">
                                <label for="job_name">Nama Pekerjaan</label>
                                <input v-model="job.name" type="text" name="name" id="job_name" class="form-control" placeholder="Masukkan nama pekerjaan..">
                            </div>
                            <div class="col form-group">
                                <label for="category">Kategori</label>
                                <select v-model="job.category" v-select2 name="category" class="form-control select2" id="category" multiple>
                                    @foreach ($categories as $id => $name)
                                        <option value="{{ $id }}">{{ $name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col form-group">
                                <label for="start_date">Tanggal Mulai</label>
                                <div class='input-group date' id='start_date'>
                                    <input v-model="job.start" type='text' name="start" class="form-control" />
                                    <span class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <div class='input-group date' id='end_date'>
                                    <input v-model="job.end" type='text' name="end" class="form-control" />
                                    <span class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col">
                <div class="card">
                    <div class="card-header bg-transparent">
                        <h3 class="mb-0">List Pekerjaan</h3>
                    </div>
                    <div class="card-body">
                        halo
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Page Content -->
@endsection

@push('bottom')
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/select2.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#start_date').datetimepicker();

        $('#end_date').datetimepicker({
            useCurrent: false
        });

        $('.select2').select2();
    });
</script>

<script>
Vue.directive('select2', {
    inserted(el) {
        $(el).on('select2:select', () => {
            const event = new Event('change', { bubbles: true, cancelable: true });
            el.dispatchEvent(event);
        });

        $(el).on('select2:unselect', () => {
            const event = new Event('change', {bubbles: true, cancelable: true})
            el.dispatchEvent(event)
        })
    },
});

new Vue({
    el: '#app',
    data: {
        job: {
            name: '',
            category: [],
            start: '',
            end: '',
        },
    },
    mounted() {
        var vm = this;

        $("#start_date").on("dp.change", (e) => {
            vm.job.start = e.date.format('YYYY-MM-DD HH:mm:ss');
            
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });

        $("#end_date").on("dp.change", (e) => {
            vm.job.end = e.date.format('YYYY-MM-DD HH:mm:ss');

            $('#start_date').data("DateTimePicker").maxDate(e.date);
        });
    }
});
</script>
@endpush