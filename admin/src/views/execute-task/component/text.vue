<style lang="less">
    @import '../../../styles/common.less';
    @import './styles/list.less';

    .text {
        /*强制换行*/
        word-wrap: break-word;
        width: 100%;
    }

    .show {
        font-size: 13px;
        color: cornflowerblue;
    }
</style>

<template>
    <div>
        <pre class="text">{{successText}}</pre>
        <div v-show="this.text && this.text.length>=this.textLength">
            <div class="show" v-if="fold" @click="expand()">展开</div>
            <div class="show" v-if="!fold" @click="noexpand()">收起</div>
        </div>
    </div>
</template>


<script>
    export default {
        name: "text-flow",
        data(){
            return {
                fold: true,
                text: null,
                textLength: 0,
                reallength: 0
            }
        },
        props: {
            textData: {
                type: String,
                default: ''
            },
            lengthData: {
                type: Number,
                default: 0
            },
        },
        computed: {
            successText: function () {
                if(!this.text) {
                    this.text = this.textData;
                    this.textLength = this.lengthData;
                }
                if (this.text && this.text.length > this.textLength) {
                    this.fold == true;
                    return this.text.trim().substring(0, this.textLength) + "...";
                } else {
                    this.fold == false;
                    return this.text;
                }
            }
        },
        methods: {
            expand(){
                this.reallength = this.textLength;
                this.textLength = this.text.length;
                this.fold = !this.fold;
            },
            noexpand(){
                this.textLength = this.reallength;
                this.fold = !this.fold;
            },
        }
    }
</script>
