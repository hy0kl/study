<html>
<head>
<script src="http://libs.baidu.com/jquery/1.9.0/jquery.js"></script>
</head>
<body>
<iframe src="/test.html?v=0" style="display: none;"></iframe>
<iframe src="/test.html?v=1" style="display: none;"></iframe>
<iframe src="/test.html?v=2" style="display: none;"></iframe>
<iframe src="/test.html?v=3" style="display: none;"></iframe>
<button id="create">创建iframe</button>
<script>
function create_iframe(src)
{
    var iframes = document.getElementsByTagName('iframe');
    for (var i = 0, len = iframes.length; i < len; i++)
    {
        console.log('i = ' + i, 'len = ' + len);
        // 父级容器是个数组, removeChild 后重新索引了
        var child = iframes[0];
        console.log(child);
        child.parentNode.removeChild(child);
    }

    var iframe = document.createElement("iframe");
    iframe.style.display = 'none';
    iframe.src = src;
    document.body.appendChild(iframe);
}

$(document).ready(function(){
    $('#create').click(function(){
        create_iframe('/test.html?p=' + (+(new Date())));
    });
});
</script>
</body>
</html>
