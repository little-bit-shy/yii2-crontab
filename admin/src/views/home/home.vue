<style lang="less">
    @import "./home.less";
    @import "../../styles/common.less";

    .manage {
        margin-bottom: 10px;
    }
</style>
<template>
    <Row>
        <Col span="24" class="manage">
            <Col span="24">
                <Alert type="warning" show-icon>定时任务管理系统：代替传统 Linux Crontab</Alert>
            </Col>

            <Col span="24">
                <client class="list"></client>
            </Col>
        </Col>

        <Col span="24">
            <list class="list"></list>
        </Col>
    </Row>
</template>
<script>
    import list from './component/list.vue';
    import client from './component/client.vue';

    export default {
        components: {list,client}
    };
</script>
