let config;
if(process.env.NODE_ENV === 'development') {
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: '/api',
        target: 'http://www.test.com/dev.php/',
        url: 'http://127.0.0.1'
    };
}else if(process.env.NODE_ENV === 'production'){
    config = {
        env: process.env.NODE_ENV,
        ajaxUrl: 'https://crontab.sayingdata.com',
        url: 'https://crontab.sayingdata.com'
    };
}
module.exports = config;
