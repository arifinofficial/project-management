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
                                <input v-model="inputs.job.name" type="text" name="name" id="job_name"
                                    class="form-control">
                            </div>
                            <div class="col form-group">
                                <label for="category">Kategori</label>
                                <select v-model="inputs.job.category" v-select2 name="category"
                                    class="form-control select2" id="category" multiple>
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
                                    <input v-model="inputs.job.start" type='text' name="start" class="form-control" />
                                    <span class="input-group-append">
                                        <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                    </span>
                                </div>
                            </div>
                            <div class="col form-group">
                                <label for="end_date">Tanggal Selesai</label>
                                <div class='input-group date' id='end_date'>
                                    <input v-model="inputs.job.end" type='text' name="end" class="form-control" />
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
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal"
                    data-target="#divisionModal" data-backdrop="static" data-keyboard="false">Buat Detail Pekerjaan</button>
            </div>
        </div>
        {{-- <div class="row">
            <div class="col-md-4" v-for="(division, index) in listDivisionTasks" :key="division.index">
                <p>@{{ index }} - @{{ division.name }}</p>
            </div>
        </div> --}}
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <h3 class="mb-0"></h3>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col" class="sort" data-sort="name">Project</th>
                                    <th scope="col" class="sort" data-sort="status">Status</th>
                                    <th scope="col" class="sort" data-sort="pic">PIC</th>
                                    <th scope="col" class="sort" data-sort="completion">Completion</th>
                                    <th scope="col"></th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                <tr v-for="(division, index) in listDivisionTasks" :key="division.index">
                                    <th scope="row">
                                        <div class="media align-items-center">
                                            <a href="#" class="avatar rounded-circle mr-3">
                                                <img alt="Image placeholder" src="../assets/img/theme/bootstrap.jpg">
                                            </a>
                                            <div class="media-body">
                                                <span class="name mb-0 text-sm">@{{ index }} - @{{ division.name }}</span>
                                            </div>
                                        </div>
                                    </th>
                                    <td>
                                        <span class="badge badge-dot mr-4">
                                            <i class="bg-warning"></i>
                                            <span class="status">pending</span>
                                        </span>
                                    </td>
                                    <td>
                                        <strong>Arifin N.</strong>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="completion mr-2">60%</span>
                                            <div>
                                                <div class="progress">
                                                    <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="60"
                                                        aria-valuemin="0" aria-valuemax="100" style="width: 60%;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        <div class="dropdown">
                                            <a class="btn btn-sm btn-icon-only text-light" href="#" role="button"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="fas fa-ellipsis-v"></i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                <button class="dropdown-item" @click.prevent="showModal(index)"><i class="fas fa-pencil-alt text-info"></i> Ubah</button>
                                                <button class="dropdown-item"><i class="fas fa-trash text-danger"></i> Hapus</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<!-- End Page Content -->
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="divisionModal" tabindex="-1" role="dialog" aria-labelledby="divisionModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="divisionModalTitle">Detail Pekerjaan</h5>
                <button type="button" class="close" @click.prevent="hideModal()">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="division_name">Nama Divisi</label>
                    <input v-model="inputs.divisions[modalActive].name" type="text" name="division_name"
                        id="division_name" class="form-control">
                    {{-- <p>@{{ countDivisions }}</p> --}}
                </div>
                <div class="container rounded py-3 mt-4" style="background-color: #e8eaf3"
                    v-for="(task, key) in inputs.divisions[modalActive].tasks" :key="key">
                    <div class="form-row">
                        <div class="col-9">
                            <input v-model="inputs.divisions[modalActive].tasks[key].name" type="text"
                                class="form-control" placeholder="Detail Pekerjaan..">
                        </div>
                        <div class="col-3">
                            <select name="" id="" class="form-control">
                                <option value="0">Belum Dikerjakan</option>
                                <option value="1">On Progress</option>
                                <option value="2">Batal</option>
                                <option value="3">Selesai</option>
                            </select>
                        </div>
                        <div class="col-12 mt-2">
                            <textarea name="" id="" cols="30" rows="2" class="form-control"
                                placeholder="Deskripsi.."></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent="removeTask(key)"
                            v-show="key || (!key && inputs.divisions[modalActive].tasks.length > 1)"><i
                                class="fas fa-minus-circle"></i></button>
                        <button v-show="key == inputs.divisions[modalActive].tasks.length - 1" type="button"
                            @click.prevent="addTask" class="btn btn-info btn-sm"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click.prevent="submitDivision()" type="button" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </div>
</div>
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
        inputs: {
            job: {
                name: '',
                category: [],
                start: '',
                end: '',
            },
            divisions: [
                {
                    name: '',
                    tasks: [
                        {
                            name: ''
                        }
                    ]
                },
            ],
        },
        modalActive: 0,
    },
    mounted() {
        var vm = this;

        $("#start_date").on("dp.change", (e) => {
            vm.inputs.job.start = e.date.format('YYYY-MM-DD HH:mm:ss');
            
            $('#end_date').data("DateTimePicker").minDate(e.date);
        });

        $("#end_date").on("dp.change", (e) => {
            vm.inputs.job.end = e.date.format('YYYY-MM-DD HH:mm:ss');

            $('#start_date').data("DateTimePicker").maxDate(e.date);
        });
    },
    computed:{
        countDivisions(){
            return this.inputs.divisions.length - 1;
        },
        listDivisionTasks(){
            return this.inputs.divisions.filter(value => value.name != "");
        }
    },
    methods: {
        submitDivision(){
            this.inputs.divisions.push(
                {
                    name: '',
                    tasks: [
                        {
                            name: ''
                        }
                    ]
                }
            );

            $('#divisionModal').modal('hide');

            this.modalActive = this.countDivisions;
        },
        addTask(){
            this.inputs.divisions[this.countDivisions].tasks.push({
                name: '',
            });
        },
        removeTask(key){
            this.inputs.divisions[this.countDivisions].tasks.splice(key, 1);
        },
        showModal(key){
            this.modalActive = key;
            console.log(key);

            $('#divisionModal').modal('show');
        },
        hideModal()
        {
            $('#divisionModal').modal('hide');

            this.modalActive = this.countDivisions;
        }
    },
});
</script>
@endpush