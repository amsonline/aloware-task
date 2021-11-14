<template>
    <ul class="list-group-flush comment-list borderless" v-if="comments">
        <comment v-for="comment in comments" v-bind:comment="comment" v-bind:collection="collection" v-bind:key="comment.id" v-bind:level="level"></comment>
    </ul>
</template>
<script>
    import Comment from './Comment.vue';
    export default{
        props: ['collection', 'comments', 'level'],
        components: {
            'comment': Comment
        }
    }
</script>