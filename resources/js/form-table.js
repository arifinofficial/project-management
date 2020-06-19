$(document).ready(function(){
    $('.container-fluid').on('click', '.editAction', function(){
        vm.$data.action.editUrl = $(this).data('action');
    });
    
    $('.container-fluid').on('click', '.deleteAction', function(){
        vm.$data.action.deleteUrl = $(this).data('action');
    });
});

var app = new Vue({
    el: '#app',
    data: {
        formAction: '',
        action: {
            storeUrl: '',
            editUrl: '',
            deleteUrl: '',
        },
        fetch: false,
        model: {},
    },
    mounted()
    {
        this.action.storeUrl = this.$refs.store_update ? this.$refs.store_update.value : '';
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
            return this.fetch == true ? this.action.storeUrl + '/' + this.model.id : this.action.storeUrl;
        },
        submitText()
        {
            return this.fetch == true ? 'Ubah' : 'Tambah';
        }
    },
    methods: {
        submitForm()
        {
            this.$validator.validate().then(valid => {
                if (valid) {
                    if (this.fetch == true) {
                        axios.patch(this.formUrl, this.model)
                        .then((response) => {
                            this.model = {};
                            this.fetch = false;
        
                            $('#dataTable').DataTable().ajax.reload();
        
                            toastr.success(response.data.message);
                        })
                        .catch((error) => {
                            let errors = error.response.data.errors;

                            toastr.error(Object.values(errors)[0]);
                        });
                    } else {
                        axios.post(this.formUrl, this.model)
                        .then((response) => {
                            this.model = {};
        
                            $('#dataTable').DataTable().ajax.reload();
        
                            toastr.success(response.data.message);
                        })
                        .catch((error) => {
                            let errors = error.response.data.errors;

                            toastr.error(Object.values(errors)[0]);
                        });
                    }
                }
            })
        },
        editMethod() {
            axios.get(this.action.editUrl)
            .then((response) => {
                this.model = response.data;
                this.fetch = true;
            })
        },
        deleteMethod() {
            axios.delete(this.action.deleteUrl)
            .then((response) => {
                $('#dataTable').DataTable().ajax.reload();

                toastr.success(response.data.message);
            })
        }
    }
});

global.vm = app;