<style lang="less">
    @import '../../../styles/common.less';
</style>

<template>
        <Row>
            <Card>
                <p slot="title">
                    <Icon type="ios-film-outline"></Icon>
                    最近任务
                </p>
                <Row>
                    <Col span="24" style="margin-bottom: 10px">
                    自动刷新：<Switch v-model="auto" true-color="#13ce66" false-color="#ff4949" />
                    </Col>
                    <Col span="24">
                        <Table  disabled-hover @on-expand="onExpand" size="small" :loading="loading" :columns="columns" :data="data"></Table>
                    </Col>
                </Row>
            </Card>
        </Row>
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
                pageSize: 50,
                pageTotal: 0,
                pageSizeOpts: [15, 20, 30, 40, 50],
                auto: true,
                columns: [
                    {
                        type: 'expand',
                        width: 30,
                        render: (h, params) => {
                            return h(drawer, {
                                props: {
                                    old_row: this.data[params.index]
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
                userId: null,
                job:[],
        };
        },
        watch: {
            page: function (newV, oldV) {
                this.getListData();
            },
            pageSize: function (newV, oldV) {
                this.getListData();
            },
        },
        methods: {
            onExpand(row,status){
                this.data.map((item, index) => {
                    if(item.id == row.id)
                    {
                        item._expanded = status;
                    }
                    return item;
                });
            },
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
                    }).then((response) => {
                    var data = response.data;
                    data.data.items.map((item,index)=>{
                        if(!this.data[index]) this.data[index] = {};
                        this.data.map((oldItem)=>{
                            if(oldItem.id == item.id && oldItem._expanded){
                                item._expanded = oldItem._expanded;
                            }
                        });
                        return item;
                    });
                    this.data = data.data.items;

                    this.pageTotal = +data.data._meta.totalCount;
                        this.loading = false;
                        this.data.splice();

                    }).catch((error) => {
                        this.loading = false;
                    });
                }, timeout);
            },
        },
        created() {
            this.getListData();
            this.job[1] = setInterval(() => {
                if(this.auto)
                {
                    this.getListData(false);
                }
            }, 5000);
        },
        beforeDestroy() {
            this.job.map(item=>{
                clearTimeout(item);
            });
        }
    };
</script>
