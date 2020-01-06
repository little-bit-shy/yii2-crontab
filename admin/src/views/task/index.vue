<style lang="less">
    .manage-users {
        margin-bottom: 10px;
    }
</style>

<template>
    <Row>
        <Col span="24">
        <list class="list"></list>
        </Col>
    </Row>
</template>

<script>
    import list from './component/list.vue';

    export default {
        components: {list}
    };
</script>
