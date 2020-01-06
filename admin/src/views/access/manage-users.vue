<style lang="less">
    .manage-users {
        margin-bottom: 10px;
    }
</style>

<template>
    <Row>
        <Col span="24">
        <manageUsers class="manage-users"></manageUsers>
        </Col>
    </Row>
</template>

<script>
    import manageUsers from './component/manage-users.vue';

    export default {
        components: {manageUsers}
    };
</script>