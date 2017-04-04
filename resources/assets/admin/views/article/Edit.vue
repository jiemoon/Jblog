<template>
    <el-form ref="form" :model="form" :rules="rules" label-width="80px" style="margin:20px;width:90%;min-width:600px;">
        <el-form-item label="标题" prop="title">
            <el-input v-model="form.title" placeholder="起个大气的标题呗"></el-input>
        </el-form-item>
        <el-form-item label="Slug" prop="slug">
            <el-input v-model="form.slug" placeholder="自动根据标题来生成"></el-input>
        </el-form-item>
        <el-form-item label="标签" prop="tags">
            <el-select v-model="form.tags" style="width:100%" multiple filterable allow-create placeholder="请选择文章标签">
                <el-option v-for="item in tags" :label="item.name" :value="item.id"></el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="发布时间" prop="publish_at">
            <el-date-picker type="date" format="yyyy-MM-dd" placeholder="选择日期" v-model="form.publish_at" ></el-date-picker>
        </el-form-item>
        <el-form-item label="摘要" prop="summary">
            <el-input type="textarea" v-model="form.summary"></el-input>
        </el-form-item>
        <el-form-item label="内容" class="theme" prop="content">
            <markdown-editor v-model="form.content" :configs="configs" ref="markdownEditor"></markdown-editor>
        </el-form-item>
        <el-form-item style="text-align: right;">
            <el-button type="info">存为草稿</el-button>
            <el-button type="primary" @click="handleSubmit" :loading="loading_publish">立即发布</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import { markdownEditor } from 'vue-simplemde'
    // require.ensure([], () => require('github-markdown-css'), 'markdown-style')
    // 使用自定义编辑器主题时
    // import 'github-markdown-css'

    import { editArticle, uploadImage, getTagList, updateArticle } from '../../api/api';

    export default {
        components: {
            markdownEditor
        },
        data() {
            return {
                tags: [],
                form: {
                    'id': '',
                    title: '',
                    slug: '',
                    publish_at: '',
                    tags: [],
                    summary: '',
                    content: '',
                },
                loading_publish: false,
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
                },
                rules: {
                    title: [
                        { required: true, message: '请输入标题', trigger: 'blur' },
                        { min: 3, max: 255, message: '长度在 3 到 255 个字', trigger: 'blur' }
                    ],
                    summary: [
                        { required: true, message: '请输入摘要', trigger: 'blur' },
                        { min: 3, max: 255, message: '长度在 3 到 255 个字', trigger: 'blur' }
                    ],
                    content: [
                        { required: true, message: '请写文章内容', trigger: 'blur' },
                        { min: 100, message: '最少要 100 个字', trigger: 'blur' }
                    ],
                }
            }
        },
        computed: {
            simplemde () {
                return this.$refs.markdownEditor.simplemde
            }
        },
        mounted() {
            this.form.content = this.simplemde.value();
            let _this = this;
            this.simplemde.codemirror.on('drop', function (editor, e) {
                var fileList = e.dataTransfer.files;
                if (fileList.length > 1){
                    _this.$message.error('一次只能上传一张图片');
                    return false;
                }
                if(fileList[0].type.indexOf('image') === -1){
                    _this.$message.error("只能上传图片！");
                    return false;
                }

                // placeholder
                let placeholder = "![Uploading " + fileList[0]['name'] + "...]()"
                editor.replaceRange(placeholder, {
                    line: editor.getCursor().line,
                    ch: editor.getCursor().ch
                });

                var img = new FormData();
                img.append('img', fileList[0]);
                uploadImage(img).then((res) => {
                    if (res.data["status"] == "success") {
                        editor.setValue(editor.getValue().replace(placeholder, "![](" + res.data['uri'] + ")"));
                    } else {
                        _this.$message.error(res.data["message"]);
                    }
                })
            });

            editArticle(this.$route.params.articleId).then((res) => {
                this.form.id = res.data.id,
                this.form.title = res.data.title;
                this.form.summary = res.data.summary;
                this.form.slug = res.data.slug;
                this.form.publish_at = res.data.publish_at;
                this.form.content = res.data.content;
                for (var i = res.data.tags.length - 1; i >= 0; i--) {
                    this.form.tags.push(res.data.tags[i].name);
                }
            });

            getTagList().then((res) => {
                this.tags = res.data;
            })
        },
        methods: {
            handleSubmit() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        this.loading_publish = true
                        updateArticle(this.form.id, this.form).then((res) => {
                            if(res.data.status == 'OK') {
                                this.$message.success('更新成功');
                                this.$router.push({ path: '/article' });
                            } else {
                                console.log(res);
                                var message = '';
                                for(var field in res.data) {
                                    message += res.data[field] + ','
                                }
                                this.$message.error(message);
                            }
                            this.loading_publish = false
                        });
                    } else {
                        return false;
                    }
                });
            },
            handleReset() {
                this.$refs.form.resetFields();
                this.simplemde.value('');
            }
        }
    }
</script>

<style>
    .theme .editor-preview-side pre,.theme .editor-preview pre {
        color: #abb2bf!important;
        background: #23241f!important;
        padding: 0.5em;
    }
    .editor-toolbar a, .editor-toolbar a.active, .editor-toolbar a:hover {
        outline: none;
    }

    .markdown-editor .CodeMirror {
        z-index: 1001;
    }

    a {
    　　-webkit-tap-highlight-color: rgba(0,0,0,0);
    　　-webkit-tap-highlight-color: transparent;
    　　outline: none;
    }

    .el-select__tags {
        width: 100%;
    }
</style>
