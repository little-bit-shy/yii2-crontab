<style lang="less">
    @import './login.less';
</style>

<template>
    <div class="login" @keydown.enter="handleSubmit">
        <div class="login-con">
            <Card :bordered="false">
                <p slot="title">
                    <Icon type="log-in"></Icon>
                    欢迎登录
                </p>
                <div class="form-con">
                    <!--登录表单-->
                    <div v-show="loginFormStatus == 1 || loginFormStatus == 2">
                        <Form ref="loginForm" :model="form" :rules="rules">
                            <FormItem prop="userName">
                                <Input v-model="form.username" placeholder="请输入用户名">
                                <span slot="prepend">
                                    <Icon :size="16" type="person"></Icon>
                                </span>
                                </Input>
                            </FormItem>
                            <FormItem prop="password">
                                <Input type="password" v-model="form.password" placeholder="请输入密码">
                                <span slot="prepend">
                                    <Icon :size="14" type="locked"></Icon>
                                </span>
                                </Input>
                            </FormItem>
                            <FormItem prop="captcha">
                                <Input v-model="form.captcha" placeholder="请输入验证码">
                                </Input>
                            </FormItem>
                            <FormItem prop="captcha">
                                <captcha :reload="captcha"></captcha>
                            </FormItem>
                            <FormItem>
                                <Button @click="handleSubmit" type="primary" long>登录</Button>
                            </FormItem>
                        </Form>
                        <p class="login-tip">请输入用户名和密码</p>
                    </div>
                    <!--登录中显示-->
                    <Spin v-show="loginFormStatus == 2" size="large" fix></Spin>
                    <!--登录成功显示-->
                    <template>
                        <Row :gutter="8" span="24">
                            <Col offset="3" span="18">
                            <div v-bind:style="{'text-align': 'center'}">
                                <Circle class="loading"
                                        v-show="loginFormStatus == 3"
                                        v-bind:size="180"
                                        v-bind:percent="loginFormpercent"
                                        v-bind:trail-width="4"
                                        v-bind:stroke-width="5"
                                        stroke-linecap="round"
                                        stroke-color="#5cb85c">
                                    <span class="demo-Circle-inner" style="font-size:24px">{{loginFormpercent}}%</span>
                                    <div class="demo-Circle-custom">
                                        <p v-show="loginFormpercent < 100">资源分配中...</p>
                                        <p v-show="loginFormpercent == 100">资源分配成功...</p>
                                    </div>
                                </Circle>
                            </div>
                            </Col>
                        </Row>
                    </template>

                    <!--登录失败显示-->
                    <template>
                        <Row :gutter="8" span="24">
                            <Col offset="3" span="18">
                            <div v-bind:style="{'text-align': 'center'}">
                                <Circle class="loading"
                                        v-show="loginFormStatus == 4"
                                        v-bind:size="180"
                                        v-bind:percent="loginFormpercent"
                                        v-bind:trail-width="4"
                                        v-bind:stroke-width="5"
                                        stroke-linecap="round"
                                        stroke-color="#ff5500">
                                    <Icon v-show="loginFormpercent == 100" type="ios-close-empty" size="50"
                                          style="color:#ff5500"></Icon>
                                    <div class="demo-Circle-custom">
                                        <span v-show="loginFormpercent < 100" class="demo-Circle-inner"
                                              style="font-size:24px">{{loginFormpercent}}%</span>
                                        <p v-show="loginFormpercent == 100">系统验证失败...</p>
                                    </div>
                                </Circle>
                            </div>
                            </Col>
                        </Row>
                    </template>

                </div>
            </Card>
        </div>
    </div>
</template>

<script>
    import Cookies from 'js-cookie';
    import notice from '../libs/notice';
    import ajax from '../libs/ajax';
    import captcha from './component/captcha.vue';

    export default {
        components: {captcha},
        data() {
            return {
                captcha: null,
                /** 表单状态：1、允许登陆 2、登陆中 3、登陆成功 4、登陆失败 */
                loginFormStatus: 1,
                /** 登录进度显示 */
                loginFormpercent: 0,
                form: {
                    captcha: '',
                    username: '',
                    password: ''
                },
                rules: {
                    username: [
                        {required: true, message: '账号不能为空', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '密码不能为空', trigger: 'blur'}
                    ]
                }
            };
        },
        methods: {
            handleSubmit() {
                this.$refs.loginForm.validate((valid) => {
                    if (valid) {
                        if (this.loginFormStatus !== 1) {
                            return;
                        }
                        /** 修改登录表单状态 */
                        this.loginFormStatus = 2;
                        (new ajax()).send('/v1/site/login', {
                            username: this.form.username,
                            password: this.form.password,
                            captcha: this.form.captcha,
                        }).then((response) => {
                            var data = response.data;
                            switch (data.success) {
                                case true:
                                    // 清除cookie
                                    var cookieData = Cookies.getJSON();
                                    for (var key in cookieData) {
                                        Cookies.remove(key);
                                    }

                                    Cookies.set('access_token', data.data.access_token);
                                    Cookies.set('user', data.data);
                                    this.$store.commit('setAvator', data.data.head);

                                    // 获取权限数据
                                    (new ajax()).send('/v1/site/all-permissions').then((response) => {
                                        var data = response.data;
                                        switch (data.success) {
                                            case true:
                                                for (var key in data.data) {
                                                    Cookies.set(key, true);
                                                }

                                                setTimeout(() => {
                                                    this.loginFormStatus = 3;
                                                    // 修改登录成功进度条
                                                    this.loginFormpercent = 0;
                                                    for (var i = 0; i < 10; i++) {
                                                        setTimeout(() => {
                                                            this.loginFormpercent += 10;
                                                        }, i * 200);
                                                    }
                                                    // 添加页面跳转任务
                                                    setTimeout(() => {
                                                        this.$router.push({
                                                            name: 'home_index'
                                                        });
                                                    }, 2500);
                                                }, 1000);
                                                break;
                                            case false:
                                                break;
                                        }
                                    });
                                    break;
                            }
                        }).catch((error) => {
                            setTimeout(() => {
                                this.loginFormStatus = 1;
                            }, 1000);
                            // 刷新验证码
                            this.captcha = new Date().getTime();
                        });
                    }
                });
            }
        },
        created() {
        }
    };
</script>

<style>

</style>
