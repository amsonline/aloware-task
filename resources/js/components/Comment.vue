<template>
    <li class="list-group-item">
        <article class="row">
            <div class="col-md-2 d-sm-none d-md-block">
                <figure class="thumbnail">
                    <img class="img-thumbnail" src="http://www.tangoflooring.ca/wp-content/uploads/2015/07/user-avatar-placeholder.png" />
                    <figcaption class="text-center">{{comment.username}}</figcaption>
                </figure>
            </div>
            <div class="col-md-10 col-sm-10">
                <div class="card arrow left">
                    <div class="card-heading right" v-if="comment.parent_id != null">Reply</div>
                    <div class="card-body">
                        <header class="text-left">
                            <div class="comment-user"><i class="fa fa-user"></i> {{comment.username}}</div>
                            <time class="comment-date" :datetime="comment.created_at"><i class="fa fa-clock-o"></i> {{getDate(comment.created_at)}}</time>
                        </header>
                        <div class="comment-post">
                            <p>
                                {{comment.content}}
                            </p>
                        </div>
                        <p class="text-right">
                            <a href="javascript:;" v-if="hasChildren" @click="replyToComment = comment" class="btn btn-outline-dark btn-sm"><i class="fa fa-reply"></i> reply</a>
                        </p>
                        <comment-form v-if="hasChildren && replyToComment == comment" :parent-id="comment.id"></comment-form>
                    </div>
                </div>
            </div>
        </article>
        <comment-list v-if="collection[comment.id]" :comments="collection[comment.id]" :collection="collection" :level="(currentLevel + 1)"></comment-list>
    </li>
</template>
<script>
    import CommentForm from './CommentForm.vue';
    export default{
        props: ['comment', 'collection', 'level'],
        data(){
            return {
                currentLevel: this.level,
                hasChildren: (this.level < 3),
                replyToComment: false
            }
        },
        mounted(){
        },
        components: {
            'comment-form': CommentForm
        },
        methods: {
            getDate(dateString) {
                var dateTime = new Date(dateString);
                return dateTime.toUTCString();
            }
        }
    }
</script>