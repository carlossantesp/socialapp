<template>
    <div>
        <form @submit.prevent="submit()" v-if="isAuthenticated">
            <div class="card-body">
                <textarea
                    v-model="body"
                    name="body"
                    class="form-control border-0 bg-light"
                    :placeholder="`¿Qué estás pensando ${currentUser.name}?`"
                ></textarea>
            </div>
            <div class="card-footer">
                <button id="create-status" class="btn btn-primary">
                    Publicar
                </button>
            </div>
        </form>
        <div v-else class="card-body">
            <a href="/login">Debe hacer login</a>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            body: ""
        };
    },
    methods: {
        submit() {
            axios.post("/statuses", { body: this.body }).then(resp => {
                EventBus.$emit("status-created", resp.data.data);
                this.body = "";
            });
        }
    }
};
</script>
