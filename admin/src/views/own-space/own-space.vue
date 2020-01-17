<style lang="less">
    @import './own-space.less';
</style>

<template>
    <div>
        <Card>
            <p slot="title">
                <Icon type="person"></Icon>
                个人信息
            </p>
            <div>

                <Row style="padding:20px">
                    <!--<Col span="24">-->
                    <!--<Avatar size="large" shape="circle" :src="this.user.head" :style="{-->
                    <!--marginBottom: '16px'-->
                <!--}"/>-->
                    <!--</Col>-->
                    <Col :xs="24" :sm="24" :md="24" :lg="24">
                    <Col span="24">
                    <span class="expand-key">密码: </span>
                    <span class="expand-value"><Button style="color: #57a3f3;" type="text" size="small" @click="showEditPassword">修改密码</Button></span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">账号名称: </span>
                    <span class="expand-value">{{ this.user.username }}</span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">绑定手机: </span>
                    <span class="expand-value">{{ this.user.phone }}</span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">绑定邮箱: </span>
                    <span class="expand-value">{{ this.user.email }}</span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">最近登录: </span>
                    <span class="expand-value">{{ this.user.last_login_ip }}</span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">最近登录: </span>
                    <span class="expand-value">{{ this.user.last_login_at }}</span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">创建时间: </span>
                    <span class="expand-value">{{ this.user.created_at }}</span>
                    </Col>
                    <Col span="24">
                    <span class="expand-key">更新时间: </span>
                    <span class="expand-value">{{ this.user.updated_at }}</span>
                    </Col>
                    </Col>
                </Row>
            </div>
        </Card>
        <Modal v-model="editPasswordModal" :closable='false' :mask-closable=false :width="500">
            <h3 slot="header" style="color:#2D8CF0">修改密码</h3>
            <Form ref="editPasswordForm" :model="editPasswordForm" :label-width="100" label-position="right"
                  :rules="passwordValidate">
                <Col span="24" v-show="editPasswordFormError !== null">
                <Alert show-icon type="error">{{editPasswordFormError}}</Alert>
                </Col>
                <FormItem label="原密码" prop="oldPass">
                    <Input type="password" v-model="editPasswordForm.oldPass" placeholder="请输入现在使用的密码"></Input>
                </FormItem>
                <FormItem label="新密码" prop="newPass">
                    <Input type="password" v-model="editPasswordForm.newPass" placeholder="请输入新密码，至少6位字符"></Input>
                </FormItem>
                <FormItem label="确认新密码" prop="rePass">
                    <Input type="password" v-model="editPasswordForm.rePass" placeholder="请再次输入新密码"></Input>
                </FormItem>
            </Form>
            <div slot="footer">
                <Button type="text" @click="cancelEditPass">取消</Button>
                <Button type="primary" :loading="savePassLoading" @click="saveEditPass">保存</Button>
            </div>
        </Modal>
    </div>
</template>

<script>
    import message from '../../libs/message';
    import cookie from 'js-cookie';
    import ajax from '../../libs/ajax';

    export default {
        name: 'ownspace_index',
        data() {
            const valideRePassword = (rule, value, callback) => {
                if (value !== this.editPasswordForm.newPass) {
                    callback(new Error('两次输入密码不一致'));
                } else {
                    callback();
                }
            };
            return {
                user: {},
                editPasswordModal: false, // 修改密码模态框显示
                savePassLoading: false,
                editPasswordFormError: null,
                editPasswordForm: {
                    oldPass: '',
                    newPass: '',
                    rePass: ''
                },
                passwordValidate: {
                    oldPass: [
                        {required: true, message: '请输入原密码', trigger: 'blur'}
                    ],
                    newPass: [
                        {required: true, message: '请输入新密码', trigger: 'blur'},
                        {min: 6, message: '请至少输入6个字符', trigger: 'blur'},
                        {max: 32, message: '最多输入32个字符', trigger: 'blur'}
                    ],
                    rePass: [
                        {required: true, message: '请再次输入新密码', trigger: 'blur'},
                        {validator: valideRePassword, trigger: 'blur'}
                    ]
                },
            };
        },
        methods: {
            showEditPassword() {
                this.editPasswordModal = true;
            },
            cancelEditPass() {
                this.editPasswordModal = false;
            },
            saveEditPass() {
                this.$refs['editPasswordForm'].validate((valid) => {
                    if (valid) {
                        this.editPass();
                    }
                });
            },
            init() {
                this.user = JSON.parse(cookie.get('user'));
            },
            editPass() {
                this.savePassLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/reset-psw-user', {
                        'password_old': this.editPasswordForm.oldPass,
                        'password_new': this.editPasswordForm.newPass
                    }, 'post', false).then((response) => {
                        var data = response.data;
                        switch (data.success) {
                            case true:
                                this.editPasswordFormError = null;
                                message.success('修改成功');
                                break;
                            case false:
                                this.editPasswordFormError = data.data.message;
                                break;
                        }
                        this.savePassLoading = false;
                    }).catch((error) => {
                        this.savePassLoading = false;
                        this.editPasswordFormError = error.message;
                    }).finally(function (callee) {
                    });
                }, 1000);
            },
        },
        mounted() {
            this.init();
        }
    };
</script>
