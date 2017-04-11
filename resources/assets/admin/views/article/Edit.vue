<template>
    <article-form @publish="publish" :form="form"></article-form>
</template>

<script>
    import ArticleForm from './Form.vue'
    import { editArticle, updateArticle } from '../../api/api'

    export default {
        components: {
            ArticleForm
        },
        data() {
            return {
                 form: {
                    title: '',
                    slug: '',
                    publish_at: '',
                    tags: [],
                    summary: '',
                    content: '',
                },
                loading_publish: false
            }
        },
        mounted() {
            editArticle(this.$route.params.articleId).then((res) => {
                this.form.id = res.data.id,
                this.form.title = res.data.title;
                this.form.summary = res.data.summary;
                this.form.slug = res.data.slug;
                this.form.publish_at = res.data.publish_at;
                this.form.content = res.data.content;
                for (var i = res.data.tags.length - 1; i >= 0; i--) {
                    this.form.tags.push(res.data.tags[i].id);
                }
            });
        },
        methods: {
            publish() {
                updateArticle(this.form.id, this.form).then((res) => {
                    if(res.data.status == 'OK') {
                        this.$message.success('更新成功')
                        this.$children[0].handleReset()
                        this.$router.push({ path: '/article' })
                    } else {
                        console.log(res);
                        var message = '';
                        for(var field in res.data) {
                            message += res.data[field] + ','
                        }
                        this.$message.error(message);
                    }
                    this.$children[0].loading_publish = false
                });
            }
        }
    }
</script>

<style>

</style>
