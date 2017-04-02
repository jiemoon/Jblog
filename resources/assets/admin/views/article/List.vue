<template>
    <section>
        <!--工具条-->
        <el-col :span="24" class="toolbar" style="padding-bottom: 0px;">
            <el-form :inline="true" :model="filters">
                <el-form-item>
                    <el-input v-model="filters.title" placeholder="标题"></el-input>
                </el-form-item>
                <el-form-item>
                    <el-button type="primary" v-on:click="getArticles">查询</el-button>
                </el-form-item>
            </el-form>
        </el-col>

        <!--列表-->
        <el-table :data="articles" highlight-current-row v-loading="listLoading"
            @selection-change="selsChange" style="width: 100%;">
            <el-table-column type="selection" width="55">
            </el-table-column>
            <el-table-column type="index" width="60">
            </el-table-column>
            <el-table-column prop="title" label="标题" min-width="120" sortable>
            </el-table-column>
            <el-table-column prop="slug" label="slug" min-width="100">
            </el-table-column>
            <el-table-column prop="status" label="状态" :formatter="formatStatus" width="100" sortable>
            </el-table-column>
            <el-table-column prop="created_at" label="创建时间" width="180">
            </el-table-column>
            <el-table-column label="操作" width="150">
                <template scope="scope">
                    <router-link :to="{name:'edit_article', params: {articleId: scope.row.id}}">
                        <el-button size="small">编辑</el-button>
                    </router-link>
                    <el-button type="danger" size="small" @click="handleDel(scope.$index, scope.row)">删除</el-button>
                </template>
            </el-table-column>
        </el-table>

        <!--编辑界面-->
        <el-dialog title="编辑" v-model="editFormVisible" :close-on-click-modal="false">
            <el-form :model="editForm" label-width="80px" :rules="editFormRules" ref="editForm">
                <el-form-item label="标题" prop="title">
                    <el-input v-model="editForm.title"></el-input>
                </el-form-item>
                <el-form-item label="标签" prop="tags">
                    <el-select v-model="editForm.tags" style="width:100%" multiple filterable allow-create placeholder="请选择文章标签">
                        <el-option v-for="item in editForm.tags" :label="item.name" :value="item.id"></el-option>
                    </el-select>
                </el-form-item>
                <el-form-item label="发布时间" prop="publish_at">
                    <el-date-picker type="date" format="yyyy-MM-dd" placeholder="选择日期" v-model="editForm.publish_at" ></el-date-picker>
                </el-form-item>
                <el-form-item label="摘要" prop="summary">
                    <el-input type="textarea" v-model="editForm.summary"></el-input>
                </el-form-item>
                <el-form-item label="内容" class="theme" prop="content">
                    <markdown-editor v-model="editForm.content" :configs="configs" ref="markdownEditor"></markdown-editor>
                </el-form-item>
            </el-form>
            <div slot="footer" class="dialog-footer">
                <el-button @click.native="editFormVisible = false">取消</el-button>
                <el-button type="primary" @click.native="editSubmit" :loading="editLoading">提交</el-button>
            </div>
        </el-dialog>
    </section>
</template>

<script>
    import { markdownEditor } from 'vue-simplemde'
    import { getArticleList, deleteArticle, editArticle } from '../../api/api';
    export default {
        components: {
            markdownEditor
        },
        data(){
            return {
                articles: [],
                listLoading: false,
                page: 1,
                total: 0,
                filters: {
                    title: ''
                },
                editFormVisible: false,//编辑界面是否显示
                editLoading: false,
                editFormRules: {
                    name: [
                        { required: true, message: '请输入姓名', trigger: 'blur' }
                    ]
                },
                //编辑界面数据
                editForm: {
                    id: 0,
                    title: '',
                    summary: '',
                    publish_at: '',
                    tags: [],
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
                },
            }
        },
        methods: {
            // 状态显示转换
            formatStatus: function (row, column) {
                return row.status == 'draft' ? '草稿' : row.status == 'published' ? '已发布' : '未知';
            },
            getArticles() {
                let para = {
                    page: this.page,
                    title: this.filters.title
                };
                this.listLoading = true;

                getArticleList(para).then((res) => {
                    console.log(res);
                    this.total = res.data.total;
                    this.articles = res.data.data;
                    this.listLoading = false;
                });
            },
            //显示编辑界面
            handleEdit: function (index, row) {
                editArticle(row.id).then((res) => {
                    this.editFormVisible = true;
                    this.editForm = {
                        id: res.data.id,
                        title: res.data.title,
                        summary: res.data.summary,
                        publish_at: res.data.publish_at,
                        tags: res.data.tags,
                        content: res.data.content,
                    }
                });
            },
            //编辑
            editSubmit: function () {
                this.$refs.editForm.validate((valid) => {
                    if (valid) {
                        this.$confirm('确认提交吗？', '提示', {}).then(() => {
                            this.editLoading = true;
                            //NProgress.start();
                            let para = Object.assign({}, this.editForm);
                            para.birth = (!para.birth || para.birth == '') ? '' : util.formatDate.format(new Date(para.birth), 'yyyy-MM-dd');
                            editUser(para).then((res) => {
                                this.editLoading = false;
                                //NProgress.done();
                                this.$message({
                                    message: '提交成功',
                                    type: 'success'
                                });
                                this.$refs['editForm'].resetFields();
                                this.editFormVisible = false;
                                this.getUsers();
                            });
                        });
                    }
                });
            },
            handleAdd() {},
            //删除
            handleDel: function (index, row) {
                this.$confirm('确认删除该记录吗?', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { id: row.id };
                    deleteArticle(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getArticles();
                    });
                }).catch(() => {

                });
            },
            selsChange() {},
            batchRemove: function () {
                var ids = this.sels.map(item => item.id).toString();
                this.$confirm('确认删除选中记录吗？', '提示', {
                    type: 'warning'
                }).then(() => {
                    this.listLoading = true;
                    //NProgress.start();
                    let para = { ids: ids };
                    batchRemoveUser(para).then((res) => {
                        this.listLoading = false;
                        //NProgress.done();
                        this.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        this.getUsers();
                    });
                }).catch(() => {

                });
            }
        },
        mounted() {
            this.getArticles();
        }
    }
</script>
