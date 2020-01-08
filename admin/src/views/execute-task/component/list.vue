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
    import drawer from './drawer.vue';

    export default {
        components: {drawer},
        names: 'list',
        data() {
            return {
                loading: false,
                page: 1,
                pageSize: 15,
                pageTotal: 0,
                pageSizeOpts: [15, 20, 30, 40, 50],
                searchForm: {
                    name: null,
                },
                columns: [
                    {
                        type: 'expand',
                        width: 30,
                        render: (h, params) => {
                            return h(drawer, {
                                props: {
                                    id: params.row.id,
                                    old_row: params.row
                                }
                            });
                        }
                    },
                    {
                        title: '命令',
                        key: 'command',
                        minWidth: 200,
                        ellipsis: true
                    },
                    {
                        title: '执行状态',
                        key: 'status',
                        width: 100,
                        align: 'center',
                        ellipsis: true,
                        render: (h, params) => {
                            return {
                                1: h('p', {
                                    style: {
                                        color: '#ff9900'
                                    }
                                }, '准备中'),
                                2: h('p', {
                                    style: {
                                        color: '#2db7f5'
                                    }
                                }, '执行中'),
                                3: h('p', {
                                    style: {
                                        color: '#ed4014'
                                    }
                                }, '任务失败'),
                                4: h('p', {
                                    style: {
                                        color: '#19be6b'
                                    }
                                }, '已完成')
                            }[params.row.status];
                        }
                    },
                    {
                        title: '数据创建时间',
                        key: 'create_time',
                        align: 'center',
                        width: 160,
                        ellipsis: true
                    },
                    {
                        title: '数据修改时间',
                        key: 'update_time',
                        align: 'center',
                        width: 160,
                        ellipsis: true
                    },
                    {
                        title: '任务计划执行时间',
                        key: 'start_time',
                        align: 'center',
                        width: 160,
                        ellipsis: true,
                    },
                    {
                        title: '任务实际执行时间',
                        key: 'execute_time',
                        align: 'center',
                        width: 160,
                        ellipsis: true,
                    },
                    {
                        title: '任务实际完成时间',
                        key: 'complete_time',
                        align: 'center',
                        width: 160,
                        ellipsis: true,
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
            },
            pageChange(index) {
                this.page = index;
            },
            pageSizeChange(index) {
                this.pageSize = index;
            },
            getListData(loading = true, timeout = 300) {
                clearTimeout(this.async);
                if (loading === true) {
                    this.loading = true;
                }
                this.async = setTimeout(() => {
                    (new ajax()).send('/v1/execute-task/index?fields=command,complete_time,create_time,execute_time,id,start_time,status,update_time&page=' + this.page + '&per-page=' + this.pageSize, {
                        'command': this.searchForm.name
                    }).then((response) => {
                        var data = response.data;
                        this.data = data.data.items;
                        this.data.map((item, index)=>{
                            if(index==0)
                            {
                                item._expanded = true;
                            }
                            return item;
                        });
                        this.pageTotal = +data.data._meta.totalCount;
                        this.loading = false;
                    }).catch((error) => {
                        this.loading = false;
                    });
                }, timeout);
            },
        },
        created() {
            this.getListData();
        }
    };
</script>
