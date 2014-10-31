/**
 * 微信相关 js 收集整理
 * */

// 判断用户是不是用微信打开了浏览器
// @see: https://gist.github.com/anhulife/8470534
function isWeixinBrowser(){
    // 截至2014年2月12日,这个方法不能测试 windows phone 中的微信浏览器
    return (/MicroMessenger/i).test(window.navigator.userAgent);
}

// 方法二
var _is_weixin_browser = 0;
document.addEventListener('WeixinJSBridgeReady', function(){
    //如果执行到这块的代码,就说明是在微信内部浏览器内打开的.
    _is_weixin_browser = 1;
    console.log('当前页面在微信内嵌浏览器中打开!');
});
