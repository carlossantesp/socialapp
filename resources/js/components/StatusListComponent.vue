<template>
    <div @click="redirectIfGuest">
        <transition-group name="status-list-transition">
            <status-list-item
                v-for="status in statuses"
                :key="status.id" :status="status"
            ></status-list-item>
        </transition-group>
    </div>
</template>

<script>
import StatusListItem from './StatusListItem'

export default {
    components: { StatusListItem },
    props: {
        url: String
    },
    data() {
        return {
            statuses: []
        };
    },
    mounted() {
        axios.get(this.getUrl).then(resp => {
            this.statuses = resp.data.data;
        });
        EventBus.$on("status-created", status => {
            this.statuses.unshift(status);
        });

        Echo.channel('statuses').listen('StatusCreated', ({status})=> {
            this.statuses.unshift(status);
        });
    },
    computed: {
        getUrl(){
            return this.url ? this.url : '/statuses';
        }
    }
};
</script>
<style>
    .status-list-transition-move{
        transition: all 0.5s;
    }
</style>
