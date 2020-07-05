<template>
    <a :href="jobUrl" class="list-group-item list-group-item-action" @click="readNotification(unread.id)">
        <div class="row align-items-center">
            <div class="col-auto">
                <img alt="Image placeholder" src=""
                    class="avatar rounded-circle">
            </div>
            <div class="col ml--2">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h4 class="mb-0 text-sm">Pekerjaan Baru - {{ unread.data.job }}</h4>
                    </div>
                    <div class="text-right text-muted">
                        <small>2 hrs ago</small>
                    </div>
                </div>
                <p class="text-sm mb-0">{{ unread.data.username }} menambahkan pekerjaan untuk anda</p>
            </div>
        </div>
    </a>
</template>

<script>
    export default {
        props: ['unread'],
        data() {
            return {
                jobUrl: "",
            }
        },
        mounted() {
            this.jobUrl=`${process.env.MIX_APP_URL}job/${this.unread.data.job_id}/edit`;
        },
        methods: {
            readNotification(id) {
                axios.post(`/api/v1/mark-as-read/${id}`)
                    .then((response) => {
                });
            }
        }
    }
</script>
