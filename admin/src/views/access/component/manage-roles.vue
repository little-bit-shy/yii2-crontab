<style lang="less">
    @import '../../../styles/common.less';
</style>

<template>
    <Card>
        <p slot="title">
            <Icon type="ios-toggle"></Icon>
            角色列表
        </p>

        <Row style="margin-bottom: 10px">
            <Col span="24">
                <Button type="success" @click="getListData()">重新加载</Button>
                <Button type="success" @click="getAddModal">添加角色</Button>
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
                    :width="50"
                    @on-visible-change="visibleChange()"
                    :closable="true">

                <Form ref="addForm" :model="addForm" :rules="addFormRule">
                    <Row :gutter="16">
                        <Col span="24" v-show="addFormError !== null">
                        <Alert show-icon type="error">{{addFormError}}</Alert>
                        </Col>

                        <Col span="8">
                        <FormItem prop="name" label="权限">
                            <Input type="text" v-model="addForm.name" placeholder="输入名称...">
                            <Icon type="ios-locked" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="8">
                        <FormItem prop="description" label="简介">
                            <Input type="text" v-model="addForm.description" placeholder="输入简介...">
                            <Icon type="drag" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="8">
                        <FormItem prop="rule_name" label="规则">
                            <Input type="text" v-model="addForm.rule_name" placeholder="输入规则...">
                            <Icon type="android-settings" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="24">
                        <FormItem prop="data" label="额外数据">
                            <Input :rows="6" type="textarea" v-model="addForm.data" placeholder="输入额外数据..."></Input>
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

                        <Col span="8">
                        <FormItem prop="name" label="权限">
                            <Input disabled type="text" v-model="updateForm.name" placeholder="输入名称...">
                            <Icon type="ios-locked" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="8">
                        <FormItem prop="description" label="简介">
                            <Input type="text" v-model="updateForm.description" placeholder="输入简介...">
                            <Icon type="drag" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="8">
                        <FormItem prop="rule_name" label="规则">
                            <Input type="text" v-model="updateForm.rule_name" placeholder="输入规则...">
                            <Icon type="android-settings" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="created_at" label="创建时间">
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

                        <Col span="24">
                        <FormItem prop="data" label="额外数据">
                            <Input :rows="6" type="textarea" v-model="updateForm.data" placeholder="输入额外数据..."></Input>
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
                    title="分配权限"
                    v-model="allotModal"
                    :loading="true"
                    :width="60"
                    :closable="true">
                <div style="overflow: hidden;">
                    <div style="height:500px;overflow: auto;margin-right: -50px;
    padding-right: 50px;">
                        <allListsWithLevel :roleName="role"
                                           v-if="allotModal"></allListsWithLevel>
                    </div>
                </div>
                <div slot="footer">
                </div>
            </Modal>

            <Modal
                    class-name="vertical-center-modal"
                    title="分配角色"
                    v-model="roleModal"
                    :loading="true"
                    :width="60"
                    :closable="true">
                <div style="overflow: hidden;">
                    <div style="height:500px;overflow: auto;">
                        <allRoleWithRole :role="role"
                                         v-if="roleModal"></allRoleWithRole>
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
    import allListsWithLevel from './all-lists-with-level';
    import allRoleWithRole from './all-role-with-role';

    export default {
        components: {allListsWithLevel,allRoleWithRole},
        names: 'manageRoles',
        data () {
            return {
                loading: false,
                page: 1,
                pageSize: 15,
                pageTotal: 0,
                pageSizeOpts: [15, 20, 30, 40, 50],
                updateModal: false,
                updateModalLoading: false,
                updateForm: {
                    name: null,
                    description: null,
                    rule_name: null,
                    data: null,
                    created_at: null,
                    updated_at: null
                },
                updateFormError: null,
                updateFormRule: {
                    name: [
                        {required: true, message: '角色不能为空', trigger: 'blur'}
                    ]
                },
                addModal: false,
                addModalLoading: false,
                addForm: {
                    name: null,
                    description: null,
                    rule_name: null,
                    data: null
                },
                addFormError: null,
                addFormRule: {
                    name: [
                        {required: true, message: '角色不能为空', trigger: 'blur'}
                    ]
                },
                allotModal: false,
                allotModalLoading: false,
                allotData: null,
                allotForm: null,
                allotFormError: null,
                allotFormRule: {},
                roleModal: false,
                roleModalLoading: false,
                roleData: null,
                roleForm: null,
                roleFormError: null,
                roleFormRule: {},
                searchForm: {
                    name: null,
                },
                columns: [
                    {
                        title: '名称',
                        key: 'name',
                        minWidth: 180,
                        ellipsis: true
                    },
                    {
                        title: '简介',
                        key: 'description',
                        minWidth: 200,
                        ellipsis: true
                    },
                    {
                        title: '规则',
                        key: 'rule_name',
                        minWidth: 200,
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
                        title: '额外数据',
                        key: 'data',
                        minWidth: 200,
                        ellipsis: true
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 200,
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
                                            this.role = this.data[index].name;
                                        }
                                    }
                                }, '权限'),
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
                                            this.roleModal = true;
                                            let index = params.index;
                                            this.role = this.data[index].name;
                                        }
                                    }
                                }, '角色'),
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
                                            this.updateForm.name = this.data[index].name;
                                            this.updateForm.description = this.data[index].description;
                                            this.updateForm.rule_name = this.data[index].rule_name;
                                            this.updateForm.data = this.data[index].data;
                                            this.updateForm.created_at = this.data[index].created_at;
                                            this.updateForm.updated_at = this.data[index].updated_at;
                                        }
                                    }
                                }, '修改'),
                                h('Button', {
                                    props: {
                                        type: 'error',
                                        size: 'small'
                                    }
                                }, [
                                    h('Poptip', {
                                        props: {
                                            confirm: true,
                                            transfer: true,
                                            placement: 'left',
                                            title: '确定要删除吗！',
                                            type: 'error',
                                            size: 'small'
                                        },
                                        on: {
                                            'on-ok': () => {
                                                let index = params.index;
                                                this.remove(this.data[index].name);
                                            }
                                        }
                                    }, '删除')
                                ])
                            ]);
                        }
                    }
                ],
                data: [],
                async: null,
                role: null
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
                this.updateFormError = null;
                this.addFormError = null;
                this.allotFormError = null;
            },
            pageChange (index) {
                this.page = index;
            },
            pageSizeChange (index) {
                this.pageSize = index;
            },
            update (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.updateData();
                    }
                });
            },
            add (name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.addData(name);
                    }
                });
            },
            remove (name) {
                this.deleteData(name);
            },
            getListData (loading = true, timeout = 300) {
                clearTimeout(this.async);
                if (loading === true) {
                    this.loading = true;
                }
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/index?page=' + this.page + '&per-page=' + this.pageSize, {
                        'type': 1,
                        'name': this.searchForm.name
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
            updateData () {
                this.updateModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/update-permissions', {
                        'name': this.updateForm.name,
                        'description': this.updateForm.description,
                        'rule_name': this.updateForm.rule_name === '' ? null : this.updateForm.rule_name,
                        'data': this.updateForm.data
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
            addData (name) {
                this.addModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/auth-item/add-role', {
                        'name': this.addForm.name,
                        'description': this.addForm.description,
                        'rule_name': this.addForm.rule_name === '' ? null : this.addForm.rule_name,
                        'data': this.addForm.data
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
            deleteData (permissions) {
                (new ajax()).send('/v1/auth-item/remove-permissions', {
                    'name': permissions
                }).then((response) => {
                    var data = response.data;
                    this.getListData(false, 1);
                    message.success('删除成功');
                }).catch((error) => {
                });
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
