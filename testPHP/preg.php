<?php
if ($_POST && $_POST['url'])
{
    $pattern = '/^([http|https]:\/\/)?(www\.)?[-a-zA-Z0-9_\/\?\.&=#%]+/';
    if (preg_match($pattern, $_POST['url']))
    {
        echo $_POST['url'] .' is a validate URL!';
    } else
    {
        echo '<font color="red">'.$_POST['url'] .' is not a validate URL.</font>';
    }
}
?>
<FORM METHOD=POST ACTION="">
  <INPUT TYPE="text" NAME="url" size="64">  </br>
  <INPUT TYPE="submit">
</FORM>