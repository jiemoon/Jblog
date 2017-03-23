<template>
    <el-form ref="form" :model="form" label-width="80px" style="margin:20px;width:90%;min-width:600px;">
        <el-form-item label="标题">
            <el-input v-model="form.title"></el-input>
        </el-form-item>
        <el-form-item label="Slogan">
            <el-input v-model="form.slogan"></el-input>
        </el-form-item>
        <el-form-item label="Topics">
            <el-checkbox-group v-model="form.topics">
                <el-checkbox label="Laravel" name="topics"></el-checkbox>
                <el-checkbox label="Vue" name="topics"></el-checkbox>
                <el-checkbox label="PHP" name="topics"></el-checkbox>
                <el-checkbox label="Linux" name="topics"></el-checkbox>
            </el-checkbox-group>
        </el-form-item>
        <el-form-item label="发布时间">
            <el-col :span="11">
                <el-date-picker type="date" placeholder="选择日期" v-model="form.publish_date" style="width: 100%;"></el-date-picker>
            </el-col>
        </el-form-item>
        <el-form-item label="内容" class="theme">
            <markdown-editor preview-class="markdown-body" v-model="form.content" :configs="configs" ref="markdownEditor"></markdown-editor>
        </el-form-item>
        <el-form-item style="text-align: right;">
            <el-button type="info">存为草稿</el-button>
            <el-button type="primary" @click="onSubmit">立即发布</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import { markdownEditor } from 'vue-simplemde'
    require.ensure([], () => require('github-markdown-css'), 'markdown-style')
    // 使用自定义编辑器主题时
    import 'github-markdown-css'

    import { addArticle } from '../../api/api';

    export default {
        components: {
            markdownEditor
        },
        data() {
            return {
                form: {
                    title: '',
                    slogan: '',
                    publish_date: '',
                    topics: [],
                    content: '',
                },
                configs: { // markdownEditor Config
                    autoDownloadFontAwesome: false,
                    // status: false, // 禁用底部状态栏
                    placeholder: '好的习惯是好的开始:-)',
                    autosave: {
                        enabled: true,
                        uniqueId: 'JBlogArticleID',
                        delay: 1000
                    },
                    renderingConfig: {
                        codeSyntaxHighlighting: true, // 开启代码高亮
                        highlightingTheme: 'monokai-sublime',
                    }
                }
            }
        },
        computed: {
            simplemde () {
                return this.$refs.markdownEditor.simplemde
            }
        },
        mounted() {
            this.$data.form.content = this.simplemde.value();
        },
        methods: {
            onSubmit() {
                addArticle(this.form).then((res) => {
                    console.log(res);
                });
            }
        }
    }
</script>

<style scoped>
    .theme .editor-preview-side pre,.theme .editor-preview pre {
        color: #abb2bf!important;
        background: #23241f!important;
        padding: 0.5em;
    }
    a {
    　　border: none;
    　　-webkit-tap-highlight-color: rgba(0,0,0,0);
    　　-webkit-tap-highlight-color: transparent;
    　　outline: none;
    }
</style>
