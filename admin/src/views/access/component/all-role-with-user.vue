<style lang="less" scoped>
    @import '../../../styles/common.less';
</style>
<template>
    <div>
        <Card :bordered="false" :dis-hover="true">
            <span v-for="(item, key) in (data || dataFirst)">
                <Checkbox v-model="check[item.name]" @on-change="onChange($event, item.name)">
                    {{ item.description }}
                </Checkbox>

                <allListsWithLevel v-if="item.children && (roleFirst || role)"
                                   :userId="userId"
                                   :role="role || roleFirst"
                                   :data="item.children">
                </allListsWithLevel>
            </span>
        </Card>
    </div>
</template>
<script>
    import ajax from "../../../libs/ajax";
    import message from "../../../libs/message";

    export default {
        name: "allRoleWithUser",
        props: {
            data: null,
            role: null,
            userId: null,
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
        methods: {
            getAllPermissionsData(timeout = 1) {
                return new Promise((resolve) => {
                    setTimeout(() => {
                        if (this.data !== undefined) {
                            return resolve();
                        }
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
                        if (this.role) {
                            return resolve();
                        }
                        (new ajax()).send('/v1/auth-item/all-role-with-user', {
                            'user_id': this.userId
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
                    this.$set(this.check, this.roleFirst[key].roleName, true);
                }
                for (let key in this.role) {
                    this.$set(this.check, this.role[key].roleName, true);
                }
            },
            onChange(type, name) {
                switch (type) {
                    case true:
                        (new ajax()).send('/v1/auth-item/add-user-role', {
                            'role': name,
                            'user_id': this.userId,
                        }).then((response) => {
                            var data = response.data;
                            message.success(data.data.message);
                        }).catch((error) => {
                        })
                        break;
                    case false:
                        (new ajax()).send('/v1/auth-item/delete-user-role', {
                            'role': name,
                            'user_id': this.userId,
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
