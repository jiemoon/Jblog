<template>
    <el-form ref="form" :model="form" :rules="rules" label-width="100px" style="margin:20px;width:90%;min-width:600px;">
        <el-form-item label="旧密码" prop="old_password">
            <el-input type="password" v-model="form.old_password"></el-input>
        </el-form-item>
        <el-form-item label="新密码" prop="new_password">
            <el-input type="password" v-model="form.new_password"></el-input>
        </el-form-item>
        <el-form-item label="确认密码" prop="confirm_password">
            <el-input type="password" v-model="form.confirm_password"></el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="handleSubmit" :loading="loading">修改密码</el-button>
        </el-form-item>
    </el-form>
</template>

<script>
    import { modifyPassword } from '../../api/api';

    export default {
        data() {
            var validateConfirmPassword = (rule, value, callback) => {
                if (value === '') {
                  callback(new Error('请再次输入密码'));
                } else if (value !== this.form.new_password) {
                  callback(new Error('两次输入密码不一致!'));
                } else {
                  callback();
                }
            }

            return {
                form: {
                    old_password: '',
                    new_password: '',
                    confirm_password: '',
                },
                rules: {
                    old_password: [
                        { required: true, message: '请输入旧密码', trigger: 'blur' },
                        { min: 6, max: 32, message: '长度在 6 到 32 个字', trigger: 'blur' }
                    ],
                    new_password: [
                        { required: true, message: '请输入新密码', trigger: 'blur' },
                        { min: 6, max: 32, message: '长度在 6 到 32 个字', trigger: 'blur' }
                    ],
                    confirm_password: [
                        { required: true, message: '请输入确认密码', trigger: 'blur' },
                        { min: 6, max: 32, message: '长度在 6 到 32 个字', trigger: 'blur' },
                        { validator: validateConfirmPassword, trigger: 'blur' }
                    ],
                },
                loading: false
            }
        },
         methods: {
            handleSubmit() {
                this.$refs.form.validate((valid) => {
                    if (valid) {
                        this.loading = true
                        modifyPassword(this.form).then((res) => {
                            if(res.data.status == 'OK') {
                                this.$message.success('修改成功');
                                this.handleReset();
                            } else {
                                var message = '';
                                for(var field in res.data) {
                                    message += res.data[field] + ','
                                }
                                this.$message.error(message);
                            }
                            this.loading = false
                        });
                    } else {
                        return false;
                    }
                });
            },
            handleReset() {
                this.$refs.form.resetFields();
            },
        }
    }
</script>
