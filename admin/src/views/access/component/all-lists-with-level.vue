<style lang="less" scoped>
    @import '../../../styles/common.less';
</style>
<template>
    <div>
        <Card :bordered="false" :dis-hover="true">
            <span v-for="(item, key) in (data || dataFirst)">
                <p slot="title" v-if="item.name && item.name.indexOf('*') >= 0">
                    <Icon type="android-folder-open"></Icon>
                    {{ item.description }}
                </p>
                <Checkbox v-model="check[item.name]" @on-change="onChange($event, item.name)" v-else>
                    {{ item.description }}
                </Checkbox>

                <allListsWithLevel v-if="item.children && (roleFirst || role)"
                                   :roleName="roleName"
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
        name: "allListsWithLevel",
        props: {
            data: null,
            role: null,
            roleName: null,
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
                        (new ajax()).send('/v1/auth-item/all-lists-with-level', {}).then((response) => {
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
                        (new ajax()).send('/v1/auth-item/all-lists-with-role', {
                            'name': this.roleName
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
                        (new ajax()).send('/v1/auth-item/add-role-permissions', {
                            'name': name,
                            'role': this.roleName,
                        }).then((response) => {
                            var data = response.data;
                            message.success(data.data.message);
                        }).catch((error) => {
                        })
                        break;
                    case false:
                        (new ajax()).send('/v1/auth-item/delete-role-permissions', {
                            'name': name,
                            'role': this.roleName,
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
