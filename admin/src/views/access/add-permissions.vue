<style lang="less">
    .add-permissions {
        margin-bottom: 10px;
    }
</style>

<template>
    <Row>
        <Col span="24">
        <addPermissions class="add-permissions"></addPermissions>
        </Col>
    </Row>
</template>

<script>
    import addPermissions from './component/add-permissions';

    export default {
        components: {addPermissions}
    };
</script>