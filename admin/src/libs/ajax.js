/**
 * axios的封装
 */
import Cookies from 'js-cookie';
import axios from 'axios';
import config from '../../build/config';
import message from './message';

class ajax {
    constructor () {
    }

    // 获取业务token
    getAccessToken () {
        return Cookies.get('access_token');
    }

    success (response) {
        // 对响应数据做点什么
        var data = response.data;
        switch (data.success) {
            case false:
                message.error(data.data.message);
                // 抛出异常给catch捕获
                throw data.data.message;
                break;
        }

        return response;
    }

    error (error) {
        // 对响应错误做点什么
        message.error(error.message);
        return Promise.reject(error);
    }

    send (path, param = {}, type = 'post', interceptorsUse = true) {
        let obj = axios.create({
            baseURL: config.ajaxUrl,
            timeout: 30000,
        });
        // 传输cookie
        obj.defaults.withCredentials = true;
        obj.interceptors.request.use((config) => {
            let params = {
                'access-token': this.getAccessToken()
            };
            config.params = params;
            return config;
        });
        // 判断拦截器的使用
        if (interceptorsUse) {
            obj.interceptors.response.use(this.success, this.error);
        }
        return obj[type](path, param);
    }
}

export default ajax;
