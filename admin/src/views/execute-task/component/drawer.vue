<style lang="less">
    @import '../../../styles/common.less';
    @import './styles/list.less';
</style>

<template>
    <div>
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
            <Col span="4">
            <p class="view-text">
                计划执行时间: {{row.start_time}}
            </p>
            </Col>
            <Col span="4">
            <p class="view-text">
                修改时间: {{row.update_time}}
            </p>
            </Col>
        </Row>
        <Row>
            <Col span="4">
            <p class="view-text">
                实际执行时间: {{row.execute_time}}
            </p>
            </Col>
            <Col span="4">
            <p class="view-text">
                创建时间: {{row.create_time}}
            </p>
            </Col>
        </Row>
        <Divider/>
        <Row>
            <Col span="24">
            <p class="view-text">
                任务输出:
            <pre>{{row.result}}</pre>
            </p>
            </Col>
        </Row>
    </div>
</template>

<script>
    export default {
        components: {},
        names: 'drawer',
        props: {
            row: {
                command: null,
                status: null,
                create_time: null,
                update_time: null,
                start_time: null,
                execute_time: null,
                result: null
            }
        },
        watch: {},
        methods: {},
        created() {
            if (this.row.result == null) {
                let $this = this;
                let tmp = {
                    1: '任务待处理，暂无输出',
                    2: '任务处理中，暂无输出',
                    3: '任务已失败，暂无输出',
                    4: '当前任务没有输出'
                };
                $this.row.result = tmp[$this.row.status];
                let num = 0;
                let how = 5;
                let result = $this.row.result;
                setInterval(function () {
                    ++num;
                    let dian = new Array(num + 1).join('.');
                    if (num % (how + 1) == 0) {
                        num = 0;
                        $this.row.result = result;
                    } else {
                        $this.row.result = result + dian;
                    }
                }, 500);
            }
        }
    };
</script>
