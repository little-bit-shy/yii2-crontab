/**
 * @desc 通知提醒
 * @type {{}}
 */
import iview from 'iview';
import vue from 'vue';

/**
 * 消息提示
 * @type {{}}
 */
let notice = {

};

notice.info = function (title, desc, duration) {
    iview.Notice.info({
        title: title || vue.t('this is the message default title'),
        desc: desc,
        duration: duration
    });
};

notice.success = function (title, desc, duration) {
    iview.Notice.success({
        title: title || vue.t('this is the message default title'),
        desc: desc,
        duration: duration
    });
};
notice.warning = function (title, desc, duration) {
    iview.Notice.warning({
        title: title || vue.t('this is the message default title'),
        desc: desc,
        duration: duration
    });
};

notice.error = function (title, desc, duration) {
    iview.Notice.error({
        title: title || vue.t('this is the message default title'),
        desc: desc,
        duration: duration
    });
};

export default notice;
