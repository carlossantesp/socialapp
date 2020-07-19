<template>
    <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle"
        href="#"
        dusk='notifications' id="dropdownNotification"
        role="button" data-toggle="dropdown" aria-haspopup="true"
        aria-expanded="false">
        <slot></slot>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownNotification">
            <a v-for="notification in notifications"
            :key="notification.id"
            :dusk="notification.id"
            :href="notification.data.link"
            class="dropdown-item"
            >{{ notification.data.message }}</a>
        </div>
    </li>
</template>

<script>
export default {
    data(){
        return {
            notifications: []
        }
    },
    created(){
        axios.get('/notifications')
        .then(res => {
            this.notifications = res.data;
        })
    }
}
</script>

<style>

</style>
