<style lang="less" scoped>
    @import '../../../styles/common.less';
    .check{
        width:150px;
    }
</style>
<template>
    <div>
        <Card :bordered="false" :dis-hover="true">
            <span v-for="(item, key) in (data || dataFirst)">
                <Checkbox class="check" v-model="check[item.name]" @on-change="onChange($event, item.name)">
                    {{ item.description|ellipsis(10) }}
                </Checkbox>
            </span>
        </Card>
    </div>
</template>
<script>
    import ajax from "../../../libs/ajax";
    import message from "../../../libs/message";

    export default {
        name: "allRoleWithRole",
        props: {
            data: null,
            role: null,
            childRole: null,
        },
        data() {
            return {
                dataFirst: null,
                roleFirst: null,
                check: {}
            }
        },
        watch: {
            check: {
                handler: function (val, oldVal) {
                },
                deep: true
            }
        },
        filters: {
            ellipsis (value,length) {
              if (!value) return ''
              if (value.length > length) {
                return value.slice(0,length) + '...'
              }
              return value
            }
        },
        methods: {
            getAllPermissionsData(timeout = 1) {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        (new ajax()).send('/v1/auth-item/all-lists', {
                            'type': 1
                        }).then((response) => {
                            var data = response.data;
                            this.dataFirst = data.data;
                        }).catch((error) => {
                        }).finally(() => {
                            resolve();
                        })
                    }, timeout);
                })
            },
            getAllPermissionsWithRoleData(timeout = 1) {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        (new ajax()).send('/v1/auth-item/all-role-with-role', {
                            'role': this.role
                        }).then((response) => {
                            var data = response.data;
                            this.roleFirst = data.data;
                        }).catch((error) => {
                        }).finally(() => {
                            resolve();
                        })
                    }, timeout);
                })
            },
            async startFunction() {
                await this.getAllPermissionsData();
                for (let key in this.data) {
                    this.$set(this.check, this.data[key].name, false);
                }
                for (let key in this.dataFirst) {
                    this.$set(this.check, this.dataFirst[key].name, false);
                }

                await this.getAllPermissionsWithRoleData();
                for (let key in this.roleFirst) {
                    this.$set(this.check, this.roleFirst[key].name, true);
                }
                for (let key in this.role) {
                    this.$set(this.check, this.role[key].name, true);
                }
            },
            onChange(type, name) {
                switch (type) {
                    case true:
                        (new ajax()).send('/v1/auth-item/add-role-role', {
                            'role': this.role,
                            'child_role': name,
                        }).then((response) => {
                            var data = response.data;
                            message.success(data.data.message);
                        }).catch((error) => {
                        })
                        break;
                    case false:
                        (new ajax()).send('/v1/auth-item/delete-role-role', {
                            'role': this.role,
                            'child_role': name,
                        }).then((response) => {
                            var data = response.data;
                            message.success(data.data.message);
                        }).catch((error) => {
                        })
                        break;
                }
            }
        },
        created() {
            this.startFunction();
        },
        beforeCreate() {
        }
    }
</script>
