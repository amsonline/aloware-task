<template>
    <div class="card">
        <div class="card-body">
            <h5 v-if="this.parentId == null">Post a comment:</h5>
            <h5 v-if="this.parentId != null">Reply to comment:</h5>
            <div class="alert alert-danger" v-if="errors.length > 0">
                <div v-for="error in errors" :key="error">
                    {{error}}
                </div>
            </div>
            <input type="text" v-model="username" class="form-control" placeholder="Username">
            <input type="text" v-model="content" class="form-control" v-on:keyup.enter="replyTo()" placeholder="Write your comment...">
        </div>
    </div>
</template>
<style>
</style>
<script>
    export default{
        props: ['parentId'],
        data(){
            return {
                content: '',
                username: '',
                errors: []
            }
        },
        methods:{
            replyTo(){
                this.errors = [];
                axios.post('/api/comment/store', {content: this.content, username: this.username, parent_id: this.parentId}).then(response => {
                    this.content = '';
                    if (response.data.success) {
                        this.$store.commit('updateComments', response.data.data);
                    }else{
                        this.errors = response.data.data;
                    }
                });
            }
        }
    }
</script>