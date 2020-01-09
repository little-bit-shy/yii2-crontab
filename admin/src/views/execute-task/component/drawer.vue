<style lang="less">
    @import '../../../styles/common.less';
    @import './styles/list.less';

    .body {
        max-height: 600px;
        overflow-y: auto;
    }

    .load{
        position: absolute;
        width: 100%;
        height: 100%;
    }

    .load-col{
        position: absolute;
        top: calc(50%);
        left: 100px;
    }

    pre {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
</style>

<template>
    <div class="body">
        <Row>
            <div class="load" v-if=load>
                <Spin size="large" class="load-col"></Spin>
            </div>
            <Row>
                <Col span="24">
                <p class="view-text">
                    命令: {{row.command}}
                </p>
                </Col>
                <Col span="24">
                <p class="view-text">
                    状态: {{{
                    1: '准备中',
                    2: '执行中',
                    3: '任务失败',
                    4: '已完成'
                    }[row.status]}}
                </p>
                </Col>
            </Row>
            <Row>
                <Col span="5">
                <p class="view-text">
                    计划执行时间: {{row.start_time}}
                </p>
                </Col>
                <Col span="5">
                <p class="view-text">
                    修改时间: {{row.update_time}}
                </p>
                </Col>
            </Row>
            <Row>
                <Col span="5">
                <p class="view-text">
                    实际执行时间: {{row.execute_time}}
                </p>
                </Col>
                <Col span="5">
                <p class="view-text">
                    创建时间: {{row.create_time}}
                </p>
                </Col>
            </Row>
            <Row>
                <Col span="5">
                <p class="view-text">
                    实际完成时间: {{row.complete_time}}
                </p>
                </Col>
                <Col span="24">
                <p class="view-text">
                    任务输出:
                <pre v-if=!row.result>{{null_result}}</pre>
                <pre v-else>{{row.result}}</pre>
                </p>
                </Col>
            </Row>
        </Row>
    </div>
</template>

<script>
    import ajax from '../../../libs/ajax';

    export default {
        components: {},
        names: 'drawer',
        data() {
            return {
                load: false,
                row: {},
                null_result:null,
                job:null,
            }
        },
        props: {
            old_row: {},
        },
        watch: {
        },
        methods: {
            async getData(load=true) {
                if(load) {
                    this.load = true;
                }
                await (new ajax()).send('/v1/execute-task/view?id='+this.old_row.id+'&fields=*&page=' + this.page + '&per-page=' + this.pageSize, {}).then((response) => {
                    var data = response.data;
                    this.row = data.data;
                    this.old_row.status = data.data.status;
                    this.old_row.complete_time = data.data.complete_time;
                    this.old_row.execute_time = data.data.execute_time;
                    this.load = false;
                }).catch((error) => {
                    this.load = false;
                });
            }
        },
        mounted() {
            this.getData().then(($result)=>{
                if (this.row.result == undefined) {
                    let tmp = {
                        1: '任务待处理，暂无输出',
                        2: '任务处理中，暂无输出',
                        3: '任务已失败，暂无输出',
                        4: '当前任务没有输出'
                    };
                    let num = 0;
                    let how = 5;
                    let result;
                    result = tmp[this.row.status];
                    this.null_result = result;
                    setInterval(() => {
                        ++num;
                        let dian = new Array(num + 1).join('.');
                        if (num % (how + 1) == 0) {
                            num = 0;
                            this.null_result = result;
                        } else {
                            this.null_result = result + dian;
                        }
                    }, 100);
                }
                this.job = setInterval(() => {
                    if(this.old_row._expanded)
                    {
                        if (this.row.status != 4) {
                            this.getData(false);
                        }
                    }
                }, 2000);
            });
        },
        beforeDestroy() {
            clearTimeout(this.job);
        }
    };
</script>
