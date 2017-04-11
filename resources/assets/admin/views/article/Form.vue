<template>
    <el-form ref="form" :model="form" :rules="rules" label-width="80px" style="margin:20px;width:90%;min-width:600px;">
        <el-form-item label="标题" prop="title">
            <el-input v-model="form.title" @blur="genSlug" placeholder="起个大气的标题呗"></el-input>
        </el-form-item>
        <el-form-item label="Slug" prop="slug">
            <el-input v-model="form.slug" placeholder="自动根据标题来生成" :loading=true></el-input>
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
            <markdown-editor :custom-theme="true" v-model="form.content" :configs="configs" ref="markdownEditor"></markdown-editor>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="handleSubmit" id="publish" :loading="loading_publish">立即发布</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import { markdownEditor } from 'vue-simplemde'
    import 'simplemde-theme-base/dist/simplemde-theme-base.min.css'
    // require.ensure([], () => require('github-markdown-css'), 'markdown-style')
    // 使用自定义编辑器主题时
    // import 'github-markdown-css'

    import { uploadImage, getTagList, genArticleSlug } from '../../api/api';

    export default {
        name: 'article-form',
        components: {
            markdownEditor
        },
        props: [ 'form' ],
        data() {
            return {
                tags: [],
                loading_serach: false,
                loading_publish: false,
                configs: { // markdownEditor Config
                    toolbar: [
                        'bold', 'italic', 'strikethrough', 'heading', '|',
                        'quote', 'unordered-list', 'ordered-list', '|',
                        'link', 'image', 'table', 'horizontal-rule', '|',
                        'preview', 'side-by-side', 'fullscreen', '|',
                        'guide',
                        {
                            name: 'publish',
                            action: function customFunction (editor) {
                                window.document.getElementById('publish').click();
                            },
                            className: 'fa fa-paper-plane',
                            title: '发布文章'
                        },
                    ],
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

            getTagList().then((res) => {
                this.tags = res.data;
            })
        },
        methods: {
            handleSubmit() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        this.loading_publish = true
                        this.$emit('publish');
                    } else {
                        return false;
                    }
                });
            },
            handleReset() {
                this.$refs.form.resetFields();
                this.simplemde.value('');
            },
            genSlug() {
                console.log('genSlug');
                genArticleSlug({ title: this.form.title }).then((res) => {
                    this.form.slug = res.data.slug
                });
            }
        }
    }
</script>

<style>
    .theme .editor-preview-side pre,.theme .editor-preview pre {
        color: #abb2bf!important;
        background: #23241f!important;
        /*padding: 0.5em;*/
    }
    .editor-toolbar a, .editor-toolbar a.active, .editor-toolbar a:hover {
        outline: none;
    }

    .markdown-editor .CodeMirror {
        z-index: 1001;
        height: 160px;
        min-height: 160px;
        padding: 0;
    }

    .markdown-editor .CodeMirror-lines {
        padding: 14px;
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
