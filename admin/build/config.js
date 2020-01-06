let config;
if(process.env.NODE_ENV === 'development') {
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: '/api',
        target: 'http://www.test.com',
        url: 'http://www.test.com'
    };
}else if(process.env.NODE_ENV === 'production'){
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: 'http://39.106.180.91:81/api',
        url: 'http://39.106.180.91:81'
    };
}
module.exports = config;
