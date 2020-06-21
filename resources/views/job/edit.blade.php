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
                    <h6 class="h2 text-white d-inline-block mb-0">Pekerjaan</h6>
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
    <div class="row justify-content-center">
        <div class=" col ">
            <div class="card">
                <div class="card-header bg-transparent">
                    <h3 class="mb-0">Pekerjaan </h3>
                    <input type="hidden" ref="id" value="{{ $id }}">
                </div>
                <div class="card-body">
                    <div class="form-row">
                        <div class="col form-group">
                            <label for="job_name">Nama Pekerjaan</label>
                            <input v-model="inputs.job.name" data-vv-as="name" v-validate="'required'" type="text" name="name" id="job_name"
                            class="form-control">
                            <span class="invalid-feedback d-block">@{{ errors.first('name') }}</span>
                        </div>
                        <div class="col form-group">
                            <label for="category">Kategori</label>
                            <select v-model="inputs.job.category" data-vv-as="category" v-validate="'required'" v-select2 name="category"
                                class="form-control select2" id="category" multiple>
                                @foreach ($categories as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                                @endforeach
                            </select>
                            <span class="invalid-feedback d-block">@{{ errors.first('category') }}</span>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="col form-group">
                            <label for="start_date">Tanggal Mulai</label>
                            <div class='input-group date' id='start_date'>
                                <input v-model="inputs.job.start" data-vv-as="start date" v-validate="'required'" type='text' name="start" class="form-control" />
                                <span class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </span>
                                <span class="invalid-feedback d-block">@{{ errors.first('start') }}</span>
                            </div>
                        </div>
                        <div class="col form-group">
                            <label for="end_date">Tanggal Selesai</label>
                            <div class='input-group date' id='end_date'>
                                <input v-model="inputs.job.end" data-vv-as="end date" v-validate="'required'" type='text' name="end" class="form-control" />
                                <span class="input-group-append">
                                    <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                                </span>
                                <span class="invalid-feedback d-block">@{{ errors.first('end') }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi</label>
                        <textarea v-model="inputs.job.description" name="description" id="description" cols="30" rows="7" class="form-control"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col">
            <button type="button" class="btn btn-sm btn-success" @click.prevent="modalDepartement()">Buat Detail Pekerjaan</button>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-12">
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
                            <tr v-for="(departement, index) in listDepartementTasks" :key="departement.index">
                                <th scope="row">
                                    <div class="media align-items-center">
                                        <div class="media-body">
                                            <span class="name mb-0 text-sm">@{{ departement.name }}</span>
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
                                    <strong>@{{ departement.pic }}</strong>
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
                                            <button class="dropdown-item" @click.prevent="removeDepartement(index)"><i class="fas fa-trash text-danger"></i> Hapus</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                @can('delete job')
                    <button class="btn btn-danger" @click.prevent="deleteJob()">Hapus</button>
                @endcan
                <button class="btn btn-primary" @click.prevent="updateJob()">Simpan</button>
            </div>
        </div>
    </div>
</div>
<!-- End Page Content -->
@endsection

@section('modal')
<!-- Modal -->
<div class="modal fade" id="departementModal" tabindex="-1" role="dialog" aria-labelledby="departementModalTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="departementModalTitle">Detail Pekerjaan</h5>
                <button type="button" class="close" @click.prevent="hideModal()">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-row">
                    <div class="col-8 form-group">
                        <label for="departement_name">Nama Divisi</label>
                            <input v-model="inputs.departements[modalActive].name" data-vv-as="name" v-validate="'required'" type="text" name="departement_name"
                            id="departement_name" class="form-control">
                            <span class="invalid-feedback d-block">@{{ errors.first('departement_name') }}</span>
                    </div>
                    <div class="col-4 form-group">
                        <label for="user_id">PIC</label>
                        <select v-model="inputs.departements[modalActive].user_id" data-vv-as="PIC" v-validate="'required'" name="user_id" class="form-control" id="user_id">
                            @foreach ($users as $id => $user)
                            <option value="{{ $id }}">{{ $user }}</option>
                            @endforeach
                        </select>
                        <span class="invalid-feedback d-block">@{{ errors.first('user_id') }}</span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="">Member</label>
                    <select v-select2 name="users" v-model="inputs.departements[modalActive].users" data-width="100%" id="" class="form-control select-users" multiple>
                        @foreach ($users as $id => $user)
                            <option value="{{ $id }}">{{ $user }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="container rounded py-3 mt-4" style="background-color: #e8eaf3"
                    v-for="(task, key) in inputs.departements[modalActive].tasks" :key="key">
                    <div class="form-row">
                        <div class="col-9">
                            <input v-model="inputs.departements[modalActive].tasks[key].name" name="task_name" data-vv-as="task name" v-validate="'required'"  type="text"
                            class="form-control" placeholder="Detail Pekerjaan..">
                            <span class="invalid-feedback d-block">@{{ errors.first('task_name') }}</span>
                        </div>
                        <div class="col-3">
                            <select name="departement_status" id="" class="form-control" v-model="inputs.departements[modalActive].tasks[key].status" data-vv-as="status" v-validate="'required'" >
                                <option value="Belum Dikerjakan">Belum Dikerjakan</option>
                                <option value="Sedang Dikerjakan">Sedang Dikerjakan</option>
                                <option value="Batal">Batal</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                            <span class="invalid-feedback d-block">@{{ errors.first('departement_status') }}</span>
                        </div>
                        <div class="col-12 mt-2">
                            <textarea v-model="inputs.departements[modalActive].tasks[key].description" name="" id="" cols="30" rows="2" class="form-control"
                                placeholder="Deskripsi.."></textarea>
                        </div>
                    </div>
                    <div class="d-flex justify-content-end mt-3">
                        <button type="button" class="btn btn-danger btn-sm" @click.prevent="removeTask(key)"
                            v-show="key || (!key && inputs.departements[modalActive].tasks.length > 1)"><i
                                class="fas fa-minus-circle"></i></button>
                        <button v-show="key == inputs.departements[modalActive].tasks.length - 1" type="button"
                            @click.prevent="addTask" class="btn btn-info btn-sm"><i
                                class="fas fa-plus-circle"></i></button>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button @click.prevent="submitDepartement()" type="button" class="btn btn-primary">Simpan</button>
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

        $('.select-users').select2();
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
        id: '',
        inputs: {
            job: {
                name: '',
                category: [],
                start: '',
                end: '',
                description: '',
            },
            departements: [
                {
                    name: '',
                    user_id: '',
                    users: [],
                    tasks: [
                        {
                            name: '',
                            status: '',
                            description: '',
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

        this.id = this.$refs.id.value;

        this.getJob(this.id)
    },
    computed:{
        countDepartements(){
            return this.inputs.departements.length - 1;
        },
        listDepartementTasks(){
            return this.inputs.departements.filter(value => value.name != "");
        }
    },
    methods: {
        getJob(id){
            axios.get('/api/v1/job/' + id)
            .then((response) => {
                const resData = response.data.data;

                this.inputs.job = resData.job;

                $('.select2').val(this.inputs.job.category);
                $('.select2').trigger('change');

                this.inputs.departements = resData.departement
            });
        },
        submitDepartement(){
            this.$validator.validate().then(valid => {
                if (valid) {

                    $('#departementModal').modal('hide');

                    this.modalActive = this.countDepartements;
                }
            });
        },
        addTask(){
            this.inputs.departements[this.modalActive].tasks.push({
                id: null,
                name: '',
                status: '',
                description: '',
            });
        },
        removeTask(key){
            if (this.inputs.departements[this.modalActive].tasks[key].id === null) {
                this.inputs.departements[this.modalActive].tasks.splice(key, 1);
            } else {
                let departementId = this.inputs.departements[this.modalActive].tasks[key].departement_id;
                let taskId = this.inputs.departements[this.modalActive].tasks[key].id;
                axios.delete(`/api/v1/job/${this.id}/${departementId}/${taskId}`)
                .then((response) => {
                    this.inputs.departements[this.modalActive].tasks.splice(key, 1);
                    toastr.success(response.data.message);
                });
            }
        },
        showModal(key){
            let departementId = this.inputs.departements[key].id;
            axios.post(`/api/v1/job/check/${this.id}/${departementId}`)
            .then((response) => {
                this.modalActive = key;

                $('#departementModal').modal({
                    backdrop: 'static',
                    keyboard: true, 
                    show: true
                });

                $('.select-users').val(this.inputs.departements[key].users);
                $('.select-users').trigger('change');
            })
            .catch((error) => {
                toastr.error("Anda tidak memiliki akses!");
            })
        },
        hideModal()
        {
            $('#departementModal').modal('hide');

            this.modalActive = this.countDepartements;
        },
        removeDepartement(key)
        {
            let departementId = this.inputs.departements[key].id;
            axios.post(`/api/v1/job/check/${this.id}/${departementId}`)
            .then((response) => {
                if (this.inputs.departements[key].id === null) {
                this.inputs.departements.splice(key, 1);    
                } else {
                    let departementId = this.inputs.departements[key].id;
                    axios.delete(`/api/v1/job/${this.id}/${departementId}`)
                    .then((response) => {
                        window.location.reload();
                    });
                }

                this.modalActive = this.countDepartements;
            })
            .catch((error) => {
                toastr.error("Anda tidak memiliki akses!");
            })
        },
        modalDepartement(){
            axios.post(`/api/v1/job/check/${this.id}`)
            .then((response) => {
                if (this.inputs.departements.length == 0 || this.inputs.departements[this.countDepartements].name != "") {
                    this.inputs.departements.push(
                        {
                            id: null,
                            name: '',
                            user_id: '',
                            users: [],
                            tasks: [
                                {
                                    id: null,
                                    name: '',
                                    status: '',
                                    description: '',
                                }
                            ]
                        }
                    );
                    
                    this.modalActive = this.countDepartements;
                }

                $('#departementModal').modal({
                    backdrop: 'static',
                    keyboard: true, 
                    show: true
                });
            })
            .catch((error) => {
                toastr.error("Anda tidak memiliki akses!");
            })
        },
        updateJob()
        {
            this.$validator.validate().then(valid => {
                if (valid) {
                    axios.patch(`/api/v1/job/${this.id}`, this.inputs)
                    .then((response) => {
                        if (response.status == 200) {
                            window.location.reload();
                        }
                    });
                }
            });
        },
        deleteJob()
        {   
            axios.delete(`/api/v1/job/${this.id}`)
            .then((response) => {
                if (response.status == 200) {
                    window.location = response.data.url
                } 
            });
        }
    },
});
</script>
@endpush