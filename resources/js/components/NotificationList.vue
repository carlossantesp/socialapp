<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
        href="#"
        dusk='notifications' id="dropdownNotification"
        role="button" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <slot></slot> <span dusk="notifications-count" class="badge badge-danger">{{ count }}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownNotification">
            <notification-list-item
                v-for="notification in notifications"
                :key="notification.id"
                :notification="notification"
            ></notification-list-item>

        </div>
    </li>
</template>

<script>
import NotificationListItem from './NotificaionListItem'

export default {
    components: { NotificationListItem },
    data(){
        return {
            notifications: [],
            count: ''
        }
    },
    created(){
        if(this.isAuthenticated)
        {
            Echo.private(`App.User.${this.currentUser.id}`)
                .notification(notification => {
                    this.count++;
                    this.notifications.push({
                        id: notification.id,
                        data: {
                            link: notification.link,
                            message: notification.message,
                        }
                    });
                });
        }

        axios.get('/notifications')
        .then(res => {
            this.notifications = res.data;
            this.unreadNotifications();
        })

        EventBus.$on('notification-read', () => {
            if(this.count === 1)
            {
                return this.count='';
            }
            this.count--;
        });

        EventBus.$on('notification-unread', () => {
            this.count++;
        });
    },
    methods:{
        unreadNotifications()
        {
            this.count = this.notifications.filter(notification => {
                return notification.read_at === null
            }).length || '';
        }
    }
}
</script>

<style>

</style>
