<style lang="less">
    @import '../../../styles/common.less';
</style>

<template>
    <Card>
        <p slot="title">
            <Icon type="ios-toggle"></Icon>
            任务列表
        </p>

        <Row style="margin-bottom: 10px">
            <Col span="24">
            <Button type="success" @click="getListData()">重新加载</Button>
            <Button type="success" @click="getAddModal">添加任务</Button>
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
                    :width="600"
                    @on-visible-change="visibleChange()"
                    :closable="true">

                <Form ref="addForm" :model="addForm" :rules="addFormRule">
                    <Row :gutter="16">
                        <Col span="24" v-show="addFormError !== null">
                        <Alert show-icon type="error">{{addFormError}}</Alert>
                        </Col>

                        <Col span="24">
                        <FormItem prop="command" label="">
                            <Input type="text" v-model="addForm.command" placeholder="输入需要执行的命令...">
                            <Icon type="ios-pricetag-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="rule" label="">
                            <Input type="text" v-model="addForm.rule" placeholder="输入需要执行的规则...">
                            <Icon type="ios-pricetag-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="24">
                        <FormItem prop="switch" label="">
                            <Switch size="large" v-model="addForm.switch" :true-value=1 :false-value=2>
                                <span slot="open">ON</span>
                                <span slot="close">OFF</span>
                            </Switch>
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
                    :width="600"
                    @on-visible-change="visibleChange()"
                    :closable="true">

                <Form ref="updateForm" :model="updateForm" :rules="updateFormRule">
                    <Row :gutter="16">
                        <Col span="24" v-show="updateFormError !== null">
                        <Alert show-icon type="error">{{updateFormError}}</Alert>
                        </Col>

                        <Col span="24">
                        <FormItem prop="command" label="">
                            <Input type="text" v-model="updateForm.command" placeholder="输入需要执行的命令...">
                            <Icon type="ios-pricetag-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="12">
                        <FormItem prop="rule" label="">
                            <Input type="text" v-model="updateForm.rule" placeholder="输入需要执行的规则...">
                            <Icon type="ios-pricetag-outline" slot="prepend"></Icon>
                            </Input>
                        </FormItem>
                        </Col>

                        <Col span="24">
                        <FormItem prop="switch" label="">
                            <Switch size="large" v-model="updateForm.switch" :true-value=1 :false-value=2>
                                <span slot="open">ON</span>
                                <span slot="close">OFF</span>
                            </Switch>
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
    import ajax from '../../../libs/ajax';
    import message from '../../../libs/message';

    export default {
        components: {},
        names: 'list',
        data() {
            return {
                loading: false,
                page: 1,
                pageSize: 15,
                pageTotal: 0,
                pageSizeOpts: [15, 20, 30, 40, 50],
                updateModal: false,
                updateModalLoading: false,
                updateForm: {
                    command: null,
                    rule: null,
                    switch: 1
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
                    command: null,
                    rule: null,
                    switch: 1
                },
                addFormError: null,
                addFormRule: {
                    command: [
                        {required: true, message: '命令不能为空', trigger: 'blur'}
                    ],
                    rule: [
                        {required: true, message: '规则不能为空', trigger: 'blur'}
                    ]
                },
                searchForm: {
                    name: null,
                },
                columns: [
                    {
                        title: '命令',
                        key: 'command',
                        minWidth: 240,
                        ellipsis: true
                    },
                    {
                        title: '时间规则',
                        key: 'rule',
                        width: 200,
                        ellipsis: true,
                    },
                    {
                        title: '开关',
                        key: 'switch',
                        width: 100,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            return {
                                1: h('p', {
                                    style: {
                                        color: 'green'
                                    }
                                }, '开启中'),
                                2: h('p', {
                                    style: {
                                        color: 'red'
                                    }
                                }, '已关闭')
                            }[params.row.switch];
                        }
                    },
                    {
                        title: '数据创建时间',
                        key: 'create_time',
                        width: 180,
                        align: 'center',
                        ellipsis: true
                    },
                    {
                        title: '数据修改时间',
                        key: 'update_time',
                        width: 180,
                        align: 'center',
                        ellipsis: true
                    },
                    {
                        title: '操作',
                        key: 'action',
                        width: 150,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            return h('div', [
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
                                            this.updateForm.command = this.data[index].command;
                                            this.updateForm.rule = this.data[index].rule;
                                            this.updateForm.switch = parseInt(this.data[index].switch);
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
                                                this.remove(this.data[index].id);
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
            visibleChange() {
                this.addFormError = null;
                this.updateFormError = null;
            },
            pageChange(index) {
                this.page = index;
            },
            pageSizeChange(index) {
                this.pageSize = index;
            },
            update(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.updateData();
                    }
                });
            },
            add(name) {
                this.$refs[name].validate((valid) => {
                    if (valid) {
                        this.addData(name);
                    }
                });
            },
            remove (id) {
                this.deleteData(id);
            },
            getListData(loading = true, timeout = 300) {
                clearTimeout(this.async);
                if (loading === true) {
                    this.loading = true;
                }
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/task/index?page=' + this.page + '&per-page=' + this.pageSize, {
                        'command': this.searchForm.name
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
            updateData() {
                this.updateModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/task/update', {
                        'id': this.updateForm.id,
                        'command': this.updateForm.command,
                        'rule': this.updateForm.rule,
                        'switch': this.updateForm.switch
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
            addData(name) {
                this.addModalLoading = true;
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/task/create', {
                        'command': this.addForm.command,
                        'rule': this.addForm.rule,
                        'switch': this.addForm.switch
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
            getAddModal() {
                this.addModal = true;
            },
            deleteData (id) {
                (new ajax()).send('/v1/task/delete', {
                    'id': id
                }).then((response) => {
                    var data = response.data;
                    this.getListData(false, 1);
                    message.success('删除成功');
                }).catch((error) => {
                });
            },
        },
        created() {
            this.getListData();
        }
    };
</script>
