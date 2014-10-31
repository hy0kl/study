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

// 屏蔽和打开微信分享按钮
var invoke_wx = function(invoke_func){
    if (typeof WeixinJSBridge == "undefined")
    {
        if (document.addEventListener)
        {
            document.addEventListener('WeixinJSBridgeReady', invoke_func, false);
        }
        else if (document.attachEvent)
        {
            document.attachEvent('WeixinJSBridgeReady', invoke_func);
            document.attachEvent('onWeixinJSBridgeReady', invoke_func);
        }
    }
    else
    {
        invoke_func();
    }
}
var switch_wx_share = {}
switch_wx_share.opt = 'show';
switch_wx_share.set_opt = function(opt)
{
    this.opt = opt;
}
switch_wx_share.invoke = function(){
    var flag = 'show' == this.opt ? 'showOptionMenu' : 'hideOptionMenu';
    WeixinJSBridge.call(flag);
    if ('show' != opt)
    {
        WeixinJSBridge.call('hideToolbar');
    }
}
switch_wx_share.show = function(){
    /** 此处不能使用 this, 在微信的回调中, this 的指向不明,会导致调用失败 */
    switch_wx_share.set_opt('show');
    switch_wx_share.invoke();
}
switch_wx_share.hide = function(){
    switch_wx_share.set_opt('hide');
    switch_wx_share.invoke();
}

invoke_wx(switch_wx_share.hide);
setTimeout(function(){
    invoke_wx(switch_wx_share.show);
}, 5000);

