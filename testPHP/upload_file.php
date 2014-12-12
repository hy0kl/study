<html>
<body>
<form action="?" id="up_file" encType="multipart/form-data" method="post">
    <input type="file" id="upload_file" name="upload_file">
    <input type="submit" value="上传文件"><span id="msg"></span>
    <br>
    <font color="red">支持JPG,JPEG,GIF,BMP,SWF,RMVB,RM,AVI文件的上传</font>
</form>
</body>
</html>
<?php
/**
 * @describe:
 * @author: Jerry Yang(hy0kle@gmail.com)
 * */
if (isset($_FILES) && count($_FILES))
{
    echo '<pre>';
    print_r($_FILES);
    echo '</pre>';
}
/* vi:set ts=4 sw=4 et fdm=marker: */

