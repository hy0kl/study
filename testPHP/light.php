<?php
header('Content-type: text/html; charset=utf-8');
if($_REQUEST['string'])
{
    $string = $_REQUEST['string'];
    if(get_magic_quotes_gpc())
    {
        $string = stripSlashes($string);
    }
    if (substr($string, 0, 5) != '<?php') 
    {
        $string = "<?php\n".$string;
    }
    highlight_string($string);
}
?>
<FORM name="test" METHOD="POST" ACTION="">
<TEXTAREA NAME="string" ROWS="12" COLS="50"></TEXTAREA>
<BR /><INPUT TYPE="submit">&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE="reset">
</FORM>