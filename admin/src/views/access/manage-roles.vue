<style lang="less">
    .manage-roles {
        margin-bottom: 10px;
    }
</style>

<template>
    <Row>
        <Col span="24">
        <manageRoles class="manage-roles"></manageRoles>
        </Col>
    </Row>
</template>

<script>
    import manageRoles from './component/manage-roles.vue';

    export default {
        components: {manageRoles}
    };
</script>