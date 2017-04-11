<template>
    <article-form @publish="publish" :form="form"></article-form>
</template>

<script>
    import ArticleForm from './Form.vue'
    import { addArticle } from '../../api/api'

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
                }
            }
        },
        methods: {
            publish() {
                addArticle(this.form).then((res) => {
                    if(res.data.status == 'OK') {
                        this.$message.success('发布成功')
                        this.$children[0].handleReset()
                    } else {
                        this.$message.error('发布失败')
                    }
                    this.$children[0].loading_publish = false
                });
            }
        }
    }
</script>

<style>

</style>
