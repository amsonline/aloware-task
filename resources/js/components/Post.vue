<template>
    <div class="card panel-default">
        <div class="card-header">
            <h3>Test post</h3>
        </div>
        <div class="card-body">
                <lorem-ipsum></lorem-ipsum>
        </div>
        <div class="card-footer bg-white">
            <div class="col-md-12">
                <comment-form :parent-id="null"></comment-form>
            </div>
            <div class="col-md-12">
                <comment-list :collection="comments" :comments="comments.root" :level="1"></comment-list>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</template>
<style scoped>
    textarea{
        resize: vertical;
    }
</style>
<script>
    import CommentList from './CommentList.vue';
    import CommentForm from './CommentForm.vue';
    import LoremIpsum from './LoremIpsum.vue';
    export default{
        data(){
            return {
                content: '',
                username: '',
                errors: []
            }
        },
        components: {
            'comment-list': CommentList,
            'comment-form': CommentForm,
            'lorem-ipsum': LoremIpsum
        },
        computed: {
            comments() {
                return this.$store.state.comments;
            }
        },
        mounted() {
            this.getComments();
        },
        methods:{
            getComments() {
                axios.get('/api/comment').then(response => {
                    console.log(response);
                    if(response.data.success){
                        this.$store.commit('initializeComments', response.data.data);
                    }else{
                        this.errors = response.data.message;
                    }
                    console.log(this.comments);
                });
            },
            post(){
                axios.post('/api/comment/store',{username: this.username, content: this.content}).then(response => {
                    console.log(response);
                    if(response.data.success){
                        this.$store.commit('pushPost', response.data.data);
                    }else{
                        this.errors = response.data.message;
                    }
                });
            }
        }
    }
</script>