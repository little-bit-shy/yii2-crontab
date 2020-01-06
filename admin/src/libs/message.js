/**
 * @desc 消息提示
 * @type {{}}
 */
import iview from 'iview';
import vue from 'vue';

/**
 * 全局消息提示
 * @type {{}}
 */
let message = {};

message.info = function (message) {
    iview.Message.info(message || vue.t('this is the default message'));
};

message.success = function (message) {
    iview.Message.success(message || vue.t('this is the default message'));
};

message.warning = function (message) {
    iview.Message.warning(message || vue.t('this is the default message'));
};

message.error = function (message) {
    iview.Message.error(message || vue.t('this is the default message'));
};

message.loading = function (message, duration) {
    iview.Message.loading({
        content: message || vue.t('this is the default message'),
        duration: duration || 0
    });
};

export default message;
