let config;
if(process.env.NODE_ENV === 'development') {
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: '/api',
        target: 'http://127.0.0.1',
        url: 'http://127.0.0.1'
    };
}else if(process.env.NODE_ENV === 'production'){
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: 'http://127.0.0.1',
        url: 'http://127.0.0.1'
    };
}
module.exports = config;
