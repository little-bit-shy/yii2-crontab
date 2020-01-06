<style lang="less">
    .manage-permissions {
        margin-bottom: 10px;
    }
</style>

<template>
    <Row>
        <Col span="24">
        <managePermissions class="manage-permissions"></managePermissions>
        </Col>
    </Row>
</template>

<script>
    import managePermissions from './component/manage-permissions.vue';

    export default {
        components: {managePermissions}
    };
</script>