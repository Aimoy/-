"use strict";
var system = require('system');
var webPage = require('webpage');
var page = webPage.create();
//设置phantomjs的浏览器user-agent
page.settings.userAgent = 'Mozilla/5.0 (iPhone; CPU iPhone OS 11_0 like Mac OS X) AppleWebKit/604.1.38 (KHTML, like Gecko) Version/11.0 Mobile/15A372 Safari/604.1';

//获取php exec 函数的命令行参数
if (system.args.length !== 3) {
    console.log(system.args);
    console.log('参数错误');
    console.log('第2个参数为url地址 第3个参数为截图文件名称');
    phantom.exit(1);
}

//命令行 截图网址参数
var url = system.args[1];
//图片输出路径
var filePath = system.args[2];

console.log('url::' + url);
console.log('filepath::' + filePath);

//设置浏览器视口
page.viewportSize = {width: 750, height: 300};
//打开网址
page.open(url, function start(status) {
    console.log(status);
    if (status !== 'success') {
        console.log('page load failed!');
        phantom.exit(1);
    } else {
        window.setTimeout(function () {
            //截图格式为jpg 80%的图片质量
            page.render(filePath, {format: 'jpg', quality: 50});
            console.log('screen shot generate succes!');
            //退出phantomjs 避免phantomjs导致内存泄露
            phantom.exit();
        }, 3000);
    }
});

