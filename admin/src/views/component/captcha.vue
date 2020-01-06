<style lang="less">
    @import '../../styles/common.less';

    .center {
        line-height: 1em;
        text-align: right;
    }
</style>

<template>
    <span>
        <Row>
            <Col span="12" offset="12">
                <div class="center">
                <Spin fix v-if="this.loading"></Spin>
                <img :src="img" @click="getCaptcha()">
                </div>
            </Col>
        </Row>
    </span>
</template>

<script>
    import ajax from '../../libs/ajax';
    import config from '../../../build/config';

    export default {
        components: {},
        names: 'captcha',
        props: ['reload'],
        data() {
            return {
                loading: true,
                img: '',
                data: [],
            };
        },
        watch: {
            reload: function (newV, oldV) {
                this.getCaptcha();
            }
        },
        methods: {
            getCaptcha() {
                this.loading = true;
                (new ajax()).send('/v1/site/captcha?refresh=1').then((response) => {
                    this.img = config.ajaxUrl + response.data.data.url;
                    this.loading = false;
                }).catch((error) => {
                    this.loading = false;
                });
            },
        },
        created() {
            this.getCaptcha();
        }
    };
</script>
