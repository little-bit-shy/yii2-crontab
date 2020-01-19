<style lang="less">
    @import '../../../styles/common.less';
</style>

<template>
        <Row>
            <Card>
                <p slot="title">
                    <Icon type="ios-film-outline"></Icon>
                    连接客户端列表
                </p>
                <Row>
                    <Col span="24">
                        <Table disabled-hover size="small" :loading="loading" :columns="columns" :data="data"></Table>
                    </Col>
                </Row>
            </Card>
        </Row>
</template>

<script>
    import ajax from '../../../libs/ajax';

    export default {
        components: {},
        names: 'client',
        data() {
            return {
                loading: false,
                pageTotal: 0,
                auto: true,
                columns: [
                    {
                        title: 'IP地址',
                        key: 'remote_ip',
                        minWidth: 200,
                        ellipsis: true
                    },
                    {
                        title: '服务端监听端口',
                        key: 'server_port',
                        minWidth: 200,
                        ellipsis: true
                    },
                    {
                        title: '客户端连接端口',
                        key: 'remote_port',
                        align: 'center',
                        width: 200,
                        ellipsis: true,
                    },
                    {
                        title: '客户端连接到服务端的时间',
                        key: 'connect_time',
                        align: 'center',
                        width: 200,
                        ellipsis: true,
                        render: (h, params) => {
                            return h('div', new Date(params.row.connect_time*1000).toLocaleString().replace(/:\d{1,2}$/, ' '))
                        }
                    },
                    {
                        title: '最后一次收到数据的时间',
                        key: 'last_time',
                        align: 'center',
                        width: 200,
                        ellipsis: true,
                        render: (h, params) => {
                        return h('div', new Date(params.row.last_time*1000).toLocaleString().replace(/:\d{1,2}$/, ' '))
                    }
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
                    (new ajax()).send('/v1/task/client', {
                    }).then((response) => {
                        var data = response.data;
                        this.data = data.data;
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
