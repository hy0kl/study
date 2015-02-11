/**
var share_data = {
  title: '互联网之子',
  desc: '在长大的过程中，我才慢慢发现，我身边的所有事，别人跟我说的所有事，那些所谓本来如此，注定如此的事，它们其实没有非得如此，事情是可以改变的。更重要的是，有些事既然错了，那就该做出改变。',
  link: 'http://movie.douban.com/subject/25785114/',
  imgUrl: 'http://img3.douban.com/view/movie_poster_cover/spst/public/p2166127561.jpg'
};

var callback = {
    trigger: function (res) {},
    complete: function (res) {},
    success: function (res) {},
    cancel: function (res) {},
    fail: function (res) {}
};
 * */

(function (window) {
    //"use strict";
    
    var wxApi = {
        version: '1.0.1'
    };

    window.wxApi = wxApi;

    /**
     * 对象简单继承，后面的覆盖前面的，继承深度：deep=1
     * @private
     */
    var _extend = function () {
        var result = {}, obj, k;
        for (var i = 0, len = arguments.length; i < len; i++) {
            obj = arguments[i];
            if (typeof obj === 'object') {
                for (k in obj) {
                    obj[k] && (result[k] = obj[k]);
                }
            }
        }

        return result;
    };

    var _merge = function(share_data, callback, fix)
    {
        var dt = {
            'title'  : share_data.title,
            'desc'   : share_data.desc,
            'link'   : share_data.link,
            'imgUrl' : share_data.imgUrl
        };
        for (var fun in callback)
        {
            dt[fun] = callback[fun];
        }
       
        /** shareToTimeline 时 title 和 desc 是反的 */
        if ('undefined' != typeof(fix) && fix)
        {
            dt.title = share_data.desc  || share_data.title;
            dt.desc  = share_data.title || share_data.desc;
        }

        return dt;
    }

    wxApi.isWeixinBrowser = function() {
        // 截至2014年2月12日,这个方法不能测试 windows phone 中的微信浏览器
        return (/MicroMessenger/i).test(window.navigator.userAgent);
    };

    // 分享到朋友圈
    wxApi.ShareTimeline = function(share_data, callback) {
        wx.onMenuShareTimeline(_merge(share_data, callback, 1));
    };

    // 分享给朋友
    wxApi.ShareAppMessage = function(share_data, callback) {
        wx.onMenuShareAppMessage(_merge(share_data, callback));
    };

    // 分享到QQ
    wxApi.ShareQQ = function(share_data, callback) {
        wx.onMenuShareQQ(_merge(share_data, callback));
    };

    // 分享到微博
    wxApi.ShareWeibo = function(share_data, callback) {
        wx.onMenuShareWeibo(_merge(share_data, callback));
    };
})(window);

$(document).ready(function(){
    wx.ready(function() {
        wxApi.ShareTimeline(share_data, callback);       
        wxApi.ShareAppMessage(share_data, callback);
        wxApi.ShareQQ(share_data, callback);
        wxApi.ShareWeibo(share_data, callback);
    });
});
