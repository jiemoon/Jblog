<template>
    <el-form ref="form" :model="form" :rules="rules" label-width="80px" style="margin:20px;width:90%;min-width:600px;">
        <el-form-item label="标题" prop="title">
            <el-input v-model="form.title"></el-input>
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

    import { addArticle, uploadImage } from '../../api/api';

    export default {
        components: {
            markdownEditor
        },
        data() {
            return {
                form: {
                    title: '',
                    publish_date: '',
                    topics: [],
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

                // tips
                let tips = "![Uploading " + fileList[0]['name'] + "...]()"
                editor.replaceRange(tips, {
                    line: editor.getCursor().line,
                    ch: editor.getCursor().ch
                });

                var img = new FormData();
                img.append('img', fileList[0]);
                uploadImage(img).then((res) => {
                    if (res.data["status"] == "success") {
                        editor.setValue(editor.getValue().replace(tips, "![](" + res.data['uri'] + ")"));
                    } else {
                        _this.$message.error(res.data["message"]);
                    }
                })
            });
        },
        methods: {
            handleSubmit() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        this.loading_publish = true
                        addArticle(this.form).then((res) => {
                            if(res.data.status == 'OK') {
                                this.$message.success('发布成功');
                                this.handleReset();
                            } else {
                                console.log(res);
                                this.$message.error('发布失败');
                            }
                            this.loading_publish = false
                        });
                    } else {
                        return false;
                    }
                });
            },
            handleReset() {
                this.simplemde.value('');
                this.$refs.form.resetFields();
            },
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

    a {
    　　-webkit-tap-highlight-color: rgba(0,0,0,0);
    　　-webkit-tap-highlight-color: transparent;
    　　outline: none;
    }
</style>
