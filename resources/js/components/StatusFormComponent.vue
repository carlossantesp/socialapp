<template>
    <div>
        <form @submit.prevent="submit()">
            <div class="card-body">
                <textarea
                    v-model="body"
                    name="body"
                    class="form-control border-0 bg-light"
                    placeholder="¿Qué estás pensando Carlos?"
                ></textarea>
            </div>
            <div class="card-footer">
                <button id="create-status" class="btn btn-primary">
                    Publicar
                </button>
            </div>
        </form>
        <ul>
            <li v-for="(status, index) in statuses" :key="index">
                {{ status.body }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    data() {
        return {
            body: "",
            statuses: []
        };
    },
    methods: {
        submit() {
            axios.post("/statuses", { body: this.body }).then(resp => {
                this.statuses.push(resp.data);
                this.body = "";
            });
        }
    }
};
</script>
