<style lang="less">
    @import '../../../styles/common.less';
</style>

<template>
    <Card>
        <p slot="title">
            <Icon type="ios-toggle"></Icon>
            用户列表
        </p>

        <Row style="margin-bottom: 10px">
            <Col span="24">
                <Button type="success" @click="getListData()">重新加载</Button>
                <Button type="success" @click="getAddModal">添加用户</Button>
            </Col>
        </Row>

        <Row>
            <Col span="6">
                <Form ref="searchForm" :model="searchForm">
                    <FormItem prop="name" label="">
                        <Input type="text" v-model="searchForm.name" placeholder="输入名称...">
                        <Icon type="ios-search" slot="prepend"></Icon>
                        </Input>
                    </FormItem>
                </Form>
            </Col>
            <Col span="24">
            <Table border size="small" :loading="loading" :columns="columns" :data="data"></Table>

            <Modal
                    class-name="vertical-center-modal"
                    title="添加数据"
                    v-model="addModal"
                    :loading="true"
                    :width="40"
                    @on-visible-change="visibleChange()"
                    :closable="true">

                <Form ref="addForm" :model="addForm" :rules="addFormRule">
                    <Row :gutter="16">
                        <Col span="24" v-show="addFormError !== null">
                        <Alert show-icon type="error">{{addFormError}}</Alert>
                        </Col>

                        <Col span="24">
                        <FormItem prop="username" label="用户名称">
                            <Input type="text" v-model="addForm.username" placeholder="输入用户名称...">
                            <Icon type="person" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="phone" label="手机号">
                            <Input type="text" v-model="addForm.phone" placeholder="输入手机号...">
                            <Icon type="iphone" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="email" label="邮箱">
                            <Input type="text" v-model="addForm.email" placeholder="输入邮箱...">
                            <Icon type="email" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="24">
                        <FormItem prop="password" label="密码">
                            <Input type="text" v-model="addForm.password" placeholder="输入密码...">
                            <Icon type="ios-locked" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                    </Row>
                </Form>

                <div slot="footer">
                    <Button type="success" size="large" :loading="addModalLoading" @click="add('addForm')">
                        确认添加
                    </Button>
                    <Button type="error" size="large" @click="addModal = false">关闭</Button>
                </div>
            </Modal>

            <Modal
                    class-name="vertical-center-modal"
                    title="修改数据"
                    v-model="updateModal"
                    :loading="true"
                    :width="50"
                    @on-visible-change="visibleChange()"
                    :closable="true">

                <Form ref="updateForm" :model="updateForm" :rules="updateFormRule">
                    <Row :gutter="16">
                        <Col span="24" v-show="updateFormError !== null">
                        <Alert show-icon type="error">{{updateFormError}}</Alert>
                        </Col>

                        <Col span="24">
                        <FormItem prop="warning" label="预警通知">
                            <Switch size="large" v-model="updateForm.warning" true-value='1' false-value='2'>
                                <span slot="open">ON</span>
                                <span slot="close">OFF</span>
                            </Switch>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="phone" label="手机号">
                            <Input type="text" v-model="updateForm.phone" placeholder="输入手机号...">
                            <Icon type="iphone" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="email" label="邮箱">
                            <Input type="text" v-model="updateForm.email" placeholder="输入邮箱...">
                            <Icon type="email" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="created_at" label="修改时间">
                            <Input disabled type="text" v-model="updateForm.created_at" placeholder="输入创建时间...">
                            <Icon type="ios-clock-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="updated_at" label="修改时间">
                            <Input disabled type="text" v-model="updateForm.updated_at" placeholder="输入修改时间...">
                            <Icon type="ios-clock-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="last_login_ip" label="输入最后一次登陆IP">
                            <Input disabled type="text" v-model="updateForm.last_login_ip" placeholder="输入最后一次登陆IP...">
                            <Icon type="ios-clock-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="last_login_at" label="最后一次登陆时间">
                            <Input disabled type="text" v-model="updateForm.last_login_at" placeholder="输入最后一次登陆时间...">
                            <Icon type="ios-clock-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                    </Row>
                </Form>

                <div slot="footer">
                    <Button type="success" size="large" :loading="updateModalLoading" @click="update('updateForm')">
                        确认修改
                    </Button>
                    <Button type="error" size="large" @click="updateModal = false">关闭</Button>
                </div>
            </Modal>

            <Modal
                    class-name="vertical-center-modal"
                    title="分配角色"
                    v-model="allotModal"
                    :loading="true"
                    :width="200"
                    :closable="true">
                <div style="overflow: hidden;">
                    <div style="height:200px;overflow: auto;margin-right: -50px;
    padding-right: 50px;">
                        <allRoleWithUser :userId="userId"
                                         v-if="allotModal"></allRoleWithUser>
                    </div>
                </div>
                <div slot="footer">
                </div>
            </Modal>
            </Col>
        </Row>
        <br/>
        <Row>
            <Col :xs="24" :lg="24">
            <Page
                    :total="pageTotal"
                    :page-size="pageSize"
                    :page-size-opts="pageSizeOpts"
                    placement="top"
                    show-total
                    show-sizer
                    show-elevator
                    @on-change="pageChange"
                    @on-page-size-change="pageSizeChange">
            </Page>
            </Col>
        </Row>

    </Card>
</template>

<script>
    import util from '../../../libs/util';
    import ajax from '../../../libs/ajax';
    import message from '../../../libs/message';
    import allRoleWithUser from './all-role-with-user';

    export default {
        components: {allRoleWithUser},
        names: 'manageUsers',
        data () {
            return {
                loading: false,
                page: 1,
                pageSize: 15,
                pageTotal: 0,
                pageSizeOpts: [15, 20, 30, 40, 50],
                allotModal: false,
                allotModalLoading: false,
                allotData: null,
                allotForm: null,
                allotFormError: null,
                allotFormRule: {},
                addModal: false,
                addModalLoading: false,
                addForm: {
                    username: null,
                    phone: null,
                    email: null,
                    password: null
                },
                addFormError: null,
                addFormRule: {
                    username: [
                        {required: true, message: '用户名称不能为空', trigger: 'blur'}
                    ],
                    password: [
                        {required: true, message: '用户密码不能为空', trigger: 'blur'}
                    ]
                },
                updateModal: false,
                updateModalLoading: false,
                updateForm: {
                    id: null,
                    warning: null,
                    email: null,
                    phone: null,
                    created_at: null,
                    updatew_at: null,
                    last_login_ip: null,
                    last_login_at: null,
                },
                updateFormError: null,
                updateFormRule: {
                    name: [

                    ]
                },
                searchForm: {
                    name: null,
                },
                columns: [
                    {
                        title: '名称',
                        key: 'username',
                        minWidth: 180,
                        ellipsis: true
                    },
                    {
                        title: '手机',
                        key: 'phone',
                        width: 180,
                        ellipsis: true
                    },
                    {
                        title: '邮箱',
                        key: 'email',
                        width: 180,
                        ellipsis: true
                    },
                    {
                        title: '创建时间',
                        key: 'created_at',
                        width: 180,
                        align: 'center',
                        ellipsis: true
                    },
                    {
                        title: '修改时间',
                        key: 'updated_at',
                        width: 180,
                        align: 'center',
                        ellipsis: true
                    },
                    {
                        title: '最后一次登陆IP',
                        key: 'last_login_ip',
                        width: 200,
                        ellipsis: true
                    },
                    {
                        title: '最后一次登陆时间',
                        key: 'last_login_at',
                        width: 200,
                        ellipsis: true
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 120,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            return h('div', [
                                h('Button', {
                                    props: {
                                        type: 'info',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.allotModal = true;
                                            let index = params.index;
                                            this.userId = this.data[index].id;
                                        }
                                    }
                                }, '分配'),
                                h('Button', {
                                    props: {
                                        type: 'success',
                                        size: 'small'
                                    },
                                    style: {
                                        marginRight: '5px'
                                    },
                                    on: {
                                        click: () => {
                                            this.updateModal = true;
                                            let index = params.index;
                                            this.updateForm.id = this.data[index].id;
                                            this.updateForm.email = this.data[index].email;
                                            this.updateForm.phone = this.data[index].phone;
                                            this.updateForm.warning = this.data[index].warning;
                                            this.updateForm.created_at = this.data[index].created_at;
                                            this.updateForm.updated_at = this.data[index].updated_at;
                                            this.updateForm.last_login_ip = this.data[index].last_login_ip;
                                            this.updateForm.last_login_at = this.data[index].last_login_at;
                                        }
                                    }
                                }, '修改'),
                            ]);
                        }
                    }
                ],
                data: [],
                async: null,
                userId: null
            };
        },
        watch: {
            page: function (newPage, oldPage) {
                this.getListData();
            },
            pageSize: function (newPageSize, oldPageSize) {
                this.getListData();
            },
            'searchForm.name': function (newPageSize, oldPageSize) {
                this.getListData();
            }
        },
        methods: {
            visibleChange () {
                this.allotFormError = null;
                this.addFormError = null;
                this.updateFormError = null;
            },
            pageChange (index) {
                this.page = index;
            },
            pageSizeChange (index) {
                this.pageSize = index;
            },
            add (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.addData(name);
                    }
                });
            },
            update (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.updateData(name);
                    }
                });
            },
            getListData (loading = true, timeout = 300) {
                clearTimeout(this.async);
                if (loading === true) {
                    this.loading = true;
                }
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/user-lists?page=' + this.page + '&per-page=' + this.pageSize, {
                        'username': this.searchForm.name
                    }).then((response) => {
                        var data = response.data;
                        this.data = data.data.items;
                        this.pageTotal = +data.data._meta.totalCount;
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                    });
                }, timeout);
            },
            addData (name) {
                this.addModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/add-user', {
                        'username': this.addForm.username,
                        'phone': this.addForm.phone,
                        'email': this.addForm.email,
                        'password': this.addForm.password
                    }, 'post', false).then((response) => {
                        var data = response.data;
                        switch (data.success) {
                            case true:
                                this.getListData(false, 1);
                                this.addFormError = null;
                                this.$refs[name].resetFields();
                                message.success('添加成功');
                                break;
                            case false:
                                this.addFormError = data.data.message;
                                break;
                        }
                        this.addModalLoading = false;
                    }).catch((error) => {
                        this.addModalLoading = false;
                        this.addFormError = error.message;
                    }).finally(function (callee) {
                    });
                }, 1000);
            },
            updateData (name) {
                this.updateModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/update-user', {
                        'id': this.updateForm.id,
                        'phone': this.updateForm.phone,
                        'email': this.updateForm.email,
                        'warning': this.updateForm.warning
                    }, 'post', false).then((response) => {
                        var data = response.data;
                        switch (data.success) {
                            case true:
                                this.getListData(false, 1);
                                this.updateFormError = null;
                                message.success('修改成功');
                                break;
                            case false:
                                this.updateFormError = data.data.message;
                                break;
                        }
                        this.updateModalLoading = false;
                    }).catch((error) => {
                        this.updateModalLoading = false;
                        this.updateFormError = error.message;
                    }).finally(function (callee) {
                    });
                }, 1000);
            },
            getAddModal () {
                this.addModal = true;
            }
        },
        created () {
            this.getListData();
        }
    };
</script>
