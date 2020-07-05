<template>
  <li class="nav-item dropdown">
    <a
      class="nav-link"
      href="#"
      role="button"
      data-toggle="dropdown"
      aria-haspopup="true"
      aria-expanded="false"
    >
      <i class="ni ni-bell-55"></i>
      <span class="badge badge-pill badge-warning">{{ unreadNotifications.length }}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-xl dropdown-menu-right py-0 overflow-hidden">
      <div class="px-3 py-3">
        <h6 class="text-sm text-muted m-0">
          Anda memiliki
          <strong class="text-primary">{{ unreadNotifications.length }}</strong> pemberitahuan.
        </h6>
      </div>
      <div class="list-group list-group-flush">
        <notification-list v-for="unread in unreadNotifications" :unread="unread" v-bind:key="unread.id"></notification-list>
      </div>
      <a href="#!" class="dropdown-item text-center text-primary font-weight-bold py-3">
        View
        all
      </a>
    </div>
  </li>
</template>

<script>
import NotificationList from './NotificationList.vue';
export default {
    props: ['unreads', 'userid'],
    components: {NotificationList},
    data(){
        return {
            unreadNotifications: this.unreads
        }
    },
    mounted() {
        Echo.private(`App.User.${this.userid}`)
        .notification(notification => {
            let newUnreadNotifications = {
                data: {
                    job: notification.job,
                    username: notification.username,
                    job_id: notification.job_id,
                }
            };

            this.unreadNotifications.push(newUnreadNotifications);  
        });
    },
};
</script>
